<?php

declare(strict_types=1);

/**
 * GoogleSheetImportService — Engine đồng bộ 1 chiều từ Google Sheet [Duvin_v1] (19 cột) vào MySQL.
 *
 * Hỗ trợ:
 *   - Kiểm tra cấu trúc 19 cột Header (VR-01)
 *   - In-Memory Taxonomy Cache (1 câu SELECT đầu batch, auto-create taxonomy mới)
 *   - Batch Preload sản phẩm theo SKU (1 câu SELECT đầu batch)
 *   - Tách Xuất xứ gộp ("Bordeaux, Pháp" -> region + country)
 *   - Tách đa niên vụ theo `;` và giống nho cùng niên vụ theo `,`
 *   - Chuẩn hóa nồng độ ABV ("14,5%" -> 14.5)
 *   - Giải mã & chuyển hóa ảnh sang .webp qua ImageUploadService
 *   - Transaction cô lập theo từng sản phẩm + ghi log chi tiết vào `import_logs`
 */
final class GoogleSheetImportService extends BaseRepository
{
    public const EXPECTED_HEADERS = [
        'Mã sản phẩm',
        'Tên sản phẩm',
        'Niên vụ',
        'Loại rượu',
        'Giống nho',
        'Xuất xứ',
        'Nhà sản xuất',
        'Nồng độ (% ABV)',
        'Đẳng cấp',
        'Giới thiệu tổng quan',
        'Tasting notes: Màu sắc',
        'Tasting notes: Mùi hương',
        'Tasting notes: Hương vị',
        'Tasting notes: Hậu vị',
        'Thông tin chi tiết sản phẩm',
        'Bảo quản & Cách thưởng thức',
        'Sản phẩm dành cho ai?',
        'Ảnh chính',
        'Thứ tự hiển thị',
    ];

    private const DEFAULT_PLACEHOLDER_IMAGE = '/assets/images/wine1.jpg';

    /** @var array<string, array<string, int>> */
    private array $taxCache = [];

    /** @var array<string, bool> */
    private array $allTaxSlugs = [];

    public function __construct(
        private ImageUploadService $imageService = new ImageUploadService(),
        private ImportLogRepository $importLogs = new ImportLogRepository()
    ) {
    }

    /**
     * Kiểm tra danh sách 19 cột tiêu đề (VR-01).
     *
     * @param array<int, mixed> $headers
     * @return array{valid: bool, message: string}
     */
    public function validateHeaders(array $headers): array
    {
        if (count($headers) < count(self::EXPECTED_HEADERS)) {
            return [
                'valid'   => false,
                'message' => sprintf(
                    'VR-01: Thiếu cột tiêu đề (nhận %d cột, yêu cầu đủ %d cột chuẩn Duvin_v1).',
                    count($headers),
                    count(self::EXPECTED_HEADERS)
                ),
            ];
        }

        foreach (self::EXPECTED_HEADERS as $idx => $expected) {
            $actual = $this->cleanText((string) ($headers[$idx] ?? ''));
            if (mb_strtolower($actual, 'UTF-8') !== mb_strtolower($expected, 'UTF-8')) {
                return [
                    'valid'   => false,
                    'message' => sprintf(
                        'VR-01: Sai tên cột thứ %d (nhận "%s", yêu cầu "%s").',
                        $idx + 1,
                        $actual,
                        $expected
                    ),
                ];
            }
        }

        return ['valid' => true, 'message' => 'OK'];
    }

    /**
     * Xử lý 1 lô dữ liệu gửi từ Google Apps Script.
     *
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function syncBatch(array $payload): array
    {
        $batchId = $this->cleanText((string) ($payload['batch_id'] ?? '')) ?: ('batch_' . date('Ymd_His') . '_' . substr(bin2hex(random_bytes(3)), 0, 6));
        $triggeredBy = $this->cleanText((string) ($payload['triggered_by'] ?? 'google_apps_script')) ?: 'google_apps_script';

        if (isset($payload['headers']) && is_array($payload['headers']) && $payload['headers'] !== []) {
            $headerCheck = $this->validateHeaders($payload['headers']);
            if (!$headerCheck['valid']) {
                return [
                    'ok'           => false,
                    'code'         => 'VR-01',
                    'batch_id'     => $batchId,
                    'message'      => $headerCheck['message'],
                    'total_rows'   => 0,
                    'success_rows' => 0,
                    'error_rows'   => 0,
                    'errors'       => [['row' => 1, 'code' => 'VR-01', 'message' => $headerCheck['message']]],
                ];
            }
        }

        $rawList = $payload['rows'] ?? $payload['products'] ?? [];
        $rows = is_array($rawList) ? $rawList : [];
        $totalRows = count($rows);
        $logId = $this->importLogs->startBatch($batchId, $totalRows, $triggeredBy);

        if ($totalRows === 0) {
            $this->importLogs->finishBatch($logId, 0, 0, []);
            return [
                'ok'           => true,
                'batch_id'     => $batchId,
                'total_rows'   => 0,
                'success_rows' => 0,
                'error_rows'   => 0,
                'inserted'     => 0,
                'updated'      => 0,
                'warnings'     => [],
                'errors'       => [],
            ];
        }

        $this->loadTaxonomyCache();

        $normalizedRows = [];
        $batchSkus = [];
        foreach ($rows as $idx => $rawRow) {
            if (!is_array($rawRow)) {
                continue;
            }
            $norm = $this->normalizeRowInput($rawRow, $idx + 2);
            $normalizedRows[] = $norm;
            if ($norm['sku'] !== '') {
                $batchSkus[] = $norm['sku'];
            }
        }

        $existingProducts = $this->preloadExistingProducts($batchSkus);
        $seenSkusInBatch = [];

        $successRows = 0;
        $errorRows = 0;
        $inserted = 0;
        $updated = 0;
        $errors = [];
        $warnings = [];

        foreach ($normalizedRows as $row) {
            $sheetRow = $row['sheet_row'];
            $sku = $row['sku'];

            // VR-02: Mã sản phẩm trống
            if ($sku === '') {
                $errorRows++;
                $errors[] = ['row' => $sheetRow, 'sku' => '', 'code' => 'VR-02', 'message' => "Dòng {$sheetRow}: Thiếu Mã sản phẩm."];
                continue;
            }

            // VR-03: Mã sản phẩm sai định dạng
            if (!preg_match('/^[A-Z0-9][A-Z0-9-]{0,49}$/', $sku)) {
                $errorRows++;
                $errors[] = ['row' => $sheetRow, 'sku' => $sku, 'code' => 'VR-03', 'message' => "Dòng {$sheetRow} ({$sku}): Mã sản phẩm chỉ chấp nhận A-Z, 0-9 và dấu gạch ngang."];
                continue;
            }

            // VR-04: Trùng SKU trong cùng lô
            if (isset($seenSkusInBatch[$sku])) {
                $errorRows++;
                $errors[] = ['row' => $sheetRow, 'sku' => $sku, 'code' => 'VR-04', 'message' => "Dòng {$sheetRow} ({$sku}): Trùng Mã sản phẩm với dòng {$seenSkusInBatch[$sku]} trong cùng lô."];
                continue;
            }
            $seenSkusInBatch[$sku] = $sheetRow;

            // VR-06: Kiểm tra các trường bắt buộc
            if ($row['name'] === '' || $row['wine_type'] === '' || $row['origin'] === '' || $row['producer'] === '') {
                $errorRows++;
                $errors[] = [
                    'row'     => $sheetRow,
                    'sku'     => $sku,
                    'code'    => 'VR-06',
                    'message' => "Dòng {$sheetRow} ({$sku}): Thiếu trường bắt buộc (Tên sản phẩm, Loại rượu, Xuất xứ hoặc Nhà sản xuất).",
                ];
                continue;
            }

            // Tách danh sách Niên vụ (VR-05)
            $rawVintages = $this->splitSemicolon($row['vintages'] !== '' ? $row['vintages'] : 'NV');
            $validVintages = [];
            foreach ($rawVintages as $vYear) {
                $vUpper = strtoupper($vYear);
                if ($vUpper === 'NV' || (preg_match('/^\d{4}$/', $vUpper) && (int) $vUpper >= 1800 && (int) $vUpper <= 2100)) {
                    if (!in_array($vUpper, $validVintages, true)) {
                        $validVintages[] = $vUpper;
                    }
                } else {
                    $warnings[] = ['row' => $sheetRow, 'sku' => $sku, 'code' => 'VR-05', 'message' => "Dòng {$sheetRow} ({$sku}): Niên vụ '{$vYear}' không hợp lệ, đã bỏ qua."];
                }
            }

            if ($validVintages === []) {
                $errorRows++;
                $errors[] = ['row' => $sheetRow, 'sku' => $sku, 'code' => 'VR-05', 'message' => "Dòng {$sheetRow} ({$sku}): Không có niên vụ nào hợp lệ (1800-2100 hoặc NV)."];
                continue;
            }

            // Xử lý ảnh Base64 -> .webp (VR-11)
            $existing = $existingProducts[$sku] ?? null;
            $primaryImage = $existing['primary_image'] ?? self::DEFAULT_PLACEHOLDER_IMAGE;

            if ($row['image_base64'] !== '') {
                try {
                    $primaryImage = $this->imageService->saveBase64AsWebp($row['image_base64'], $sku);
                } catch (Throwable $imgErr) {
                    $warnings[] = [
                        'row'     => $sheetRow,
                        'sku'     => $sku,
                        'code'    => 'VR-11',
                        'message' => "Dòng {$sheetRow} ({$sku}): Lỗi xử lý ảnh ({$imgErr->getMessage()}), dùng ảnh dự phòng.",
                    ];
                }
            } elseif ($existing === null) {
                $warnings[] = [
                    'row'     => $sheetRow,
                    'sku'     => $sku,
                    'code'    => 'VR-11',
                    'message' => "Dòng {$sheetRow} ({$sku}): Sản phẩm mới chưa có ảnh trong ô, đã gán ảnh mặc định.",
                ];
            }

            // Bọc Transaction cô lập cho từng sản phẩm
            $pdo = $this->db();
            $pdo->beginTransaction();
            try {
                $wineTypeId = $this->resolveTaxonomy('wine_type', $row['wine_type']);
                [$countryId, $regionId] = $this->resolveOrigin($row['origin']);
                $producerId = $this->resolveTaxonomy('producer', $row['producer']);

                $vintageCount = count($validVintages);
                $abvList = $this->alignPerVintage($this->splitSemicolon($row['abv']), $vintageCount, $sheetRow, $sku, 'Nồng độ', $warnings);
                $classList = $this->alignPerVintage($this->splitSemicolon($row['classification']), $vintageCount, $sheetRow, $sku, 'Đẳng cấp', $warnings);
                $grapeGroups = $this->alignPerVintage($this->splitSemicolon($row['grapes']), $vintageCount, $sheetRow, $sku, 'Giống nho', $warnings);
                $colorList = $this->alignPerVintage($this->splitSemicolon($row['taste_color']), $vintageCount, $sheetRow, $sku, 'Màu sắc', $warnings);
                $aromaList = $this->alignPerVintage($this->splitSemicolon($row['taste_aroma']), $vintageCount, $sheetRow, $sku, 'Mùi hương', $warnings);
                $palateList = $this->alignPerVintage($this->splitSemicolon($row['taste_palate']), $vintageCount, $sheetRow, $sku, 'Hương vị', $warnings);
                $finishList = $this->alignPerVintage($this->splitSemicolon($row['taste_finish']), $vintageCount, $sheetRow, $sku, 'Hậu vị', $warnings);

                $firstClassId = $classList[0] !== '' ? $this->resolveTaxonomy('classification', $classList[0]) : null;
                $displayOrder = $this->parseDisplayOrder($row['display_order'], $sheetRow);
                $shortDesc = $this->truncate($row['short_description'], 5000);
                $fullDesc = $this->truncate($row['full_description'], 15000);
                $storageAdvice = $this->truncate($row['storage_advice'], 5000);
                $targetAudience = $this->truncate($row['target_audience'], 5000);

                if ($existing !== null) {
                    $productId = (int) $existing['id'];
                    $this->query(
                        'UPDATE products
                         SET name = :name,
                             producer_id = :producer_id,
                             wine_type_id = :wine_type_id,
                             country_id = :country_id,
                             region_id = :region_id,
                             classification_id = :classification_id,
                             primary_image = :primary_image,
                             short_description = :short_description,
                             full_description = :full_description,
                             storage_advice = :storage_advice,
                             target_audience = :target_audience,
                             display_order = :display_order,
                             is_active = 1
                         WHERE id = :id',
                        [
                            'name'              => $row['name'],
                            'producer_id'       => $producerId,
                            'wine_type_id'      => $wineTypeId,
                            'country_id'        => $countryId,
                            'region_id'         => $regionId,
                            'classification_id' => $firstClassId,
                            'primary_image'     => $primaryImage,
                            'short_description' => $shortDesc,
                            'full_description'  => $fullDesc,
                            'storage_advice'    => $storageAdvice,
                            'target_audience'   => $targetAudience,
                            'display_order'     => $displayOrder,
                            'id'                => $productId,
                        ]
                    );
                    $updated++;
                } else {
                    $slug = $this->uniqueProductSlug($row['name'], $sku);
                    $this->query(
                        'INSERT INTO products (
                             sku, name, slug, producer_id, wine_type_id, country_id, region_id,
                             classification_id, primary_image, short_description, full_description,
                             storage_advice, target_audience, display_order, is_featured, is_rare, is_active
                         ) VALUES (
                             :sku, :name, :slug, :producer_id, :wine_type_id, :country_id, :region_id,
                             :classification_id, :primary_image, :short_description, :full_description,
                             :storage_advice, :target_audience, :display_order, 0, 0, 1
                         )',
                        [
                            'sku'               => $sku,
                            'name'              => $row['name'],
                            'slug'              => $slug,
                            'producer_id'       => $producerId,
                            'wine_type_id'      => $wineTypeId,
                            'country_id'        => $countryId,
                            'region_id'         => $regionId,
                            'classification_id' => $firstClassId,
                            'primary_image'     => $primaryImage,
                            'short_description' => $shortDesc,
                            'full_description'  => $fullDesc,
                            'storage_advice'    => $storageAdvice,
                            'target_audience'   => $targetAudience,
                            'display_order'     => $displayOrder,
                        ]
                    );
                    $productId = (int) $pdo->lastInsertId();
                    $existingProducts[$sku] = ['id' => $productId, 'sku' => $sku, 'slug' => $slug, 'primary_image' => $primaryImage];
                    $inserted++;
                }

                // Đồng bộ từng niên vụ & giống nho
                foreach ($validVintages as $vIdx => $vYear) {
                    $abvVal = $this->parseAbv($abvList[$vIdx], $sheetRow, $sku, $warnings);
                    $vClassId = $classList[$vIdx] !== '' ? $this->resolveTaxonomy('classification', $classList[$vIdx]) : $firstClassId;

                    $vintageId = $this->upsertVintage(
                        $productId,
                        $vYear,
                        $abvVal,
                        $vClassId,
                        $colorList[$vIdx],
                        $aromaList[$vIdx],
                        $palateList[$vIdx],
                        $finishList[$vIdx]
                    );

                    // Cập nhật giống nho cho niên vụ này
                    $this->query('DELETE FROM product_vintage_grapes WHERE vintage_id = :vid', ['vid' => $vintageId]);
                    $grapeNames = $this->splitComma($grapeGroups[$vIdx]);
                    $seenGrapeIds = [];
                    foreach ($grapeNames as $gName) {
                        $grapeId = $this->resolveTaxonomy('grape', $gName);
                        if ($grapeId !== null && !isset($seenGrapeIds[$grapeId])) {
                            $seenGrapeIds[$grapeId] = true;
                            $this->query(
                                'INSERT INTO product_vintage_grapes (vintage_id, grape_id, percentage) VALUES (:vid, :gid, NULL)',
                                ['vid' => $vintageId, 'gid' => $grapeId]
                            );
                        }
                    }
                }

                $pdo->commit();
                $successRows++;
            } catch (Throwable $e) {
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }
                $errorRows++;
                $errors[] = [
                    'row'     => $sheetRow,
                    'sku'     => $sku,
                    'code'    => 'DB-ERR',
                    'message' => "Dòng {$sheetRow} ({$sku}): Lỗi lưu CSDL — " . $e->getMessage(),
                ];
            }
        }

        $this->importLogs->finishBatch($logId, $successRows, $errorRows, array_merge($errors, $warnings));

        return [
            'ok'           => true,
            'batch_id'     => $batchId,
            'total_rows'   => $totalRows,
            'success_rows' => $successRows,
            'error_rows'   => $errorRows,
            'inserted'     => $inserted,
            'updated'      => $updated,
            'warnings'     => $warnings,
            'errors'       => $errors,
        ];
    }

    /**
     * Chuẩn hóa input 1 dòng (hỗ trợ cả mảng 19 cột theo index 0..18 hoặc object theo key).
     *
     * @param array<int|string, mixed> $raw
     * @return array<string, mixed>
     */
    private function normalizeRowInput(array $raw, int $defaultRowNumber): array
    {
        $cells = isset($raw['cells']) && is_array($raw['cells']) ? $raw['cells'] : $raw;
        $isIndexed = array_is_list($cells);

        $get = function (int $idx, string $key, ?string $alias = null) use ($cells, $raw, $isIndexed): string {
            if ($isIndexed) {
                return $this->cleanText((string) ($cells[$idx] ?? ''));
            }
            $val = $cells[$key] ?? $raw[$key] ?? ($alias !== null ? ($cells[$alias] ?? $raw[$alias] ?? null) : null) ?? $cells[$idx] ?? '';
            return $this->cleanText((string) $val);
        };

        $sku = strtoupper($get(0, 'sku'));
        return [
            'sheet_row'         => (int) ($raw['row_number'] ?? $raw['row'] ?? $defaultRowNumber),
            'sku'               => $sku,
            'name'              => $get(1, 'name'),
            'vintages'          => $get(2, 'vintages'),
            'wine_type'         => $get(3, 'wine_type'),
            'grapes'            => $get(4, 'grapes'),
            'origin'            => $get(5, 'origin'),
            'producer'          => $get(6, 'producer'),
            'abv'               => $get(7, 'abv'),
            'classification'    => $get(8, 'classification'),
            'short_description' => $get(9, 'short_description', 'short_desc'),
            'taste_color'       => $get(10, 'taste_color', 'tasting_color'),
            'taste_aroma'       => $get(11, 'taste_aroma', 'tasting_aroma'),
            'taste_palate'      => $get(12, 'taste_palate', 'tasting_palate'),
            'taste_finish'      => $get(13, 'taste_finish', 'tasting_finish'),
            'full_description'  => $get(14, 'full_description', 'description'),
            'storage_advice'    => $get(15, 'storage_advice', 'serving_guide'),
            'target_audience'   => $get(16, 'target_audience', 'audience'),
            'image_cell'        => $get(17, 'image_cell'),
            'display_order'     => $get(18, 'display_order', 'sort_order'),
            'image_base64'      => trim((string) ($raw['image_base64'] ?? '')),
        ];
    }

    private function loadTaxonomyCache(): void
    {
        $this->taxCache = [];
        $this->allTaxSlugs = [];
        $rows = $this->fetchAll('SELECT id, type, slug, name FROM taxonomies');
        foreach ($rows as $r) {
            $type = (string) $r['type'];
            $slug = (string) $r['slug'];
            $nameKey = $this->slugify((string) $r['name']);
            $id = (int) $r['id'];

            $this->taxCache[$type][$slug] = $id;
            if ($nameKey !== '') {
                $this->taxCache[$type][$nameKey] = $id;
            }
            $this->allTaxSlugs[$slug] = true;
        }
    }

    /**
     * @param array<int, string> $skus
     * @return array<string, array<string, mixed>>
     */
    private function preloadExistingProducts(array $skus): array
    {
        $unique = array_values(array_unique(array_filter($skus)));
        if ($unique === []) {
            return [];
        }

        $placeholders = implode(', ', array_fill(0, count($unique), '?'));
        $rows = $this->fetchAll(
            "SELECT id, sku, slug, primary_image FROM products WHERE sku IN ({$placeholders})",
            $unique
        );

        $map = [];
        foreach ($rows as $r) {
            $map[strtoupper((string) $r['sku'])] = $r;
        }
        return $map;
    }

    private function resolveTaxonomy(string $type, string $name, ?int $parentId = null): ?int
    {
        $cleanName = $this->cleanText($name);
        if ($cleanName === '') {
            return null;
        }

        $baseSlug = $this->slugify($cleanName);
        if ($baseSlug === '') {
            return null;
        }

        if (isset($this->taxCache[$type][$baseSlug])) {
            return $this->taxCache[$type][$baseSlug];
        }

        // Trường hợp wine_type "Pháp" -> "vang-phap" hoặc tìm slug có sẵn
        if ($type === 'country' && isset($this->taxCache[$type]['vang-' . $baseSlug])) {
            return $this->taxCache[$type]['vang-' . $baseSlug];
        }

        $uniqueSlug = $baseSlug;
        if (isset($this->allTaxSlugs[$uniqueSlug])) {
            $uniqueSlug = $type . '-' . $baseSlug;
            $suffix = 2;
            while (isset($this->allTaxSlugs[$uniqueSlug])) {
                $uniqueSlug = $type . '-' . $baseSlug . '-' . $suffix++;
            }
        }

        $this->query(
            'INSERT INTO taxonomies (parent_id, type, name, slug, display_order, is_active)
             VALUES (:parent_id, :type, :name, :slug, 99, 1)',
            [
                'parent_id' => $parentId,
                'type'      => $type,
                'name'      => $cleanName,
                'slug'      => $uniqueSlug,
            ]
        );

        $newId = (int) $this->db()->lastInsertId();
        $this->taxCache[$type][$baseSlug] = $newId;
        $this->taxCache[$type][$uniqueSlug] = $newId;
        $this->allTaxSlugs[$uniqueSlug] = true;

        return $newId;
    }

    /**
     * Tách chuỗi Xuất xứ ("Bordeaux, Pháp" -> [country_id, region_id]).
     *
     * @return array{0: ?int, 1: ?int}
     */
    private function resolveOrigin(string $origin): array
    {
        $parts = $this->splitComma($origin);
        if ($parts === []) {
            return [null, null];
        }

        if (count($parts) === 1) {
            return [$this->resolveTaxonomy('country', $parts[0]), null];
        }

        $countryName = (string) array_pop($parts);
        $regionName = implode(', ', $parts);

        $countryId = $this->resolveTaxonomy('country', $countryName);
        $regionId = $this->resolveTaxonomy('region', $regionName, $countryId);

        return [$countryId, $regionId];
    }

    private function upsertVintage(
        int $productId,
        string $vintageYear,
        ?float $abv,
        ?int $classificationId,
        string $color,
        string $aroma,
        string $palate,
        string $finish
    ): int {
        $existing = $this->fetch(
            'SELECT id FROM product_vintages WHERE product_id = :pid AND vintage_year = :vy LIMIT 1',
            ['pid' => $productId, 'vy' => $vintageYear]
        );

        if ($existing !== null) {
            $vid = (int) $existing['id'];
            $this->query(
                'UPDATE product_vintages
                 SET alcohol_abv = :abv,
                     classification_id = :cid,
                     color = :color,
                     aroma = :aroma,
                     palate = :palate,
                     finish = :finish,
                     is_active = 1
                 WHERE id = :id',
                [
                    'abv'    => $abv,
                    'cid'    => $classificationId,
                    'color'  => $this->truncate($color, 255),
                    'aroma'  => $this->truncate($aroma, 255),
                    'palate' => $this->truncate($palate, 255),
                    'finish' => $this->truncate($finish, 255),
                    'id'     => $vid,
                ]
            );
            return $vid;
        }

        $this->query(
            'INSERT INTO product_vintages (
                 product_id, vintage_year, price, alcohol_abv, volume,
                 classification_id, color, aroma, palate, finish, in_stock, is_active
             ) VALUES (
                 :pid, :vy, 0, :abv, \'750ml\',
                 :cid, :color, :aroma, :palate, :finish, 1, 1
             )',
            [
                'pid'    => $productId,
                'vy'     => $vintageYear,
                'abv'    => $abv,
                'cid'    => $classificationId,
                'color'  => $this->truncate($color, 255),
                'aroma'  => $this->truncate($aroma, 255),
                'palate' => $this->truncate($palate, 255),
                'finish' => $this->truncate($finish, 255),
            ]
        );

        return (int) $this->db()->lastInsertId();
    }

    /**
     * Căn chỉnh mảng thuộc tính theo số lượng niên vụ của dòng.
     *
     * @param array<int, string> $items
     * @param array<int, array<string, mixed>> $warnings
     * @return array<int, string>
     */
    private function alignPerVintage(array $items, int $count, int $sheetRow, string $sku, string $fieldLabel, array &$warnings): array
    {
        if ($items === []) {
            return array_fill(0, $count, '');
        }
        if (count($items) === 1) {
            return array_fill(0, $count, $items[0]);
        }
        if (count($items) !== $count) {
            $warnings[] = [
                'row'     => $sheetRow,
                'sku'     => $sku,
                'code'    => 'VR-13',
                'message' => "Dòng {$sheetRow} ({$sku}): Số phần tử '{$fieldLabel}' (" . count($items) . ") lệch với số Niên vụ ({$count}), đã tự động căn chỉnh.",
            ];
        }

        $aligned = [];
        $last = end($items) ?: '';
        for ($i = 0; $i < $count; $i++) {
            $aligned[] = $items[$i] ?? $last;
        }
        return $aligned;
    }

    /**
     * @param array<int, array<string, mixed>> $warnings
     */
    private function parseAbv(string $raw, int $sheetRow, string $sku, array &$warnings): ?float
    {
        $clean = str_replace(['%', ' ', ','], ['', '', '.'], trim($raw));
        if ($clean === '') {
            return null;
        }
        if (!is_numeric($clean)) {
            $warnings[] = ['row' => $sheetRow, 'sku' => $sku, 'code' => 'VR-09', 'message' => "Dòng {$sheetRow} ({$sku}): Nồng độ '{$raw}' không phải số hợp lệ, đã gán NULL."];
            return null;
        }
        $val = round((float) $clean, 1);
        if ($val < 0.0 || $val > 25.0) {
            $warnings[] = ['row' => $sheetRow, 'sku' => $sku, 'code' => 'VR-09', 'message' => "Dòng {$sheetRow} ({$sku}): Nồng độ '{$raw}' nằm ngoài khoảng 0-25%, đã gán NULL."];
            return null;
        }
        return $val;
    }

    private function parseDisplayOrder(string $raw, int $fallbackOrder): int
    {
        $clean = trim($raw);
        if ($clean !== '' && ctype_digit($clean) && (int) $clean > 0) {
            return (int) $clean;
        }
        return max(1, $fallbackOrder);
    }

    private function uniqueProductSlug(string $name, string $sku): string
    {
        $base = $this->slugify($name);
        if ($base === '') {
            $base = strtolower($sku);
        }

        $exists = $this->fetch('SELECT id FROM products WHERE slug = :slug LIMIT 1', ['slug' => $base]);
        if ($exists === null) {
            return $base;
        }

        $withSku = $base . '-' . strtolower($sku);
        $existsSku = $this->fetch('SELECT id FROM products WHERE slug = :slug LIMIT 1', ['slug' => $withSku]);
        if ($existsSku === null) {
            return $withSku;
        }

        return $withSku . '-' . substr(bin2hex(random_bytes(2)), 0, 4);
    }

    /**
     * @return array<int, string>
     */
    private function splitSemicolon(string $value): array
    {
        $trimmed = trim($value);
        if ($trimmed === '') {
            return [];
        }
        return array_values(array_filter(
            array_map(fn (string $s): string => $this->cleanText($s), explode(';', $trimmed)),
            static fn (string $s): bool => $s !== ''
        ));
    }

    /**
     * @return array<int, string>
     */
    private function splitComma(string $value): array
    {
        $trimmed = trim($value);
        if ($trimmed === '') {
            return [];
        }
        return array_values(array_filter(
            array_map(fn (string $s): string => $this->cleanText($s), explode(',', $trimmed)),
            static fn (string $s): bool => $s !== ''
        ));
    }

    private function cleanText(string $text): string
    {
        $cleaned = str_replace("\xC2\xA0", ' ', $text); // non-breaking space \u00A0
        $cleaned = strip_tags($cleaned);
        $cleaned = (string) preg_replace('/\s+/u', ' ', $cleaned);
        return trim($cleaned);
    }

    private function truncate(string $text, int $maxLength): string
    {
        if (mb_strlen($text, 'UTF-8') <= $maxLength) {
            return $text;
        }
        return mb_substr($text, 0, $maxLength, 'UTF-8');
    }

    public function slugify(string $text): string
    {
        $str = mb_strtolower($this->cleanText($text), 'UTF-8');
        $vietnameseMap = [
            '/[àáạảãâầấậẩẫăằắặẳẵ]/u' => 'a',
            '/[èéẹẻẽêềếệểễ]/u'       => 'e',
            '/[ìíịỉĩ]/u'             => 'i',
            '/[òóọỏõôồốộổỗơờớợởỡ]/u' => 'o',
            '/[ùúụủũưừứựửữ]/u'       => 'u',
            '/[ỳýỵỷỹ]/u'             => 'y',
            '/đ/u'                   => 'd',
        ];
        $str = (string) preg_replace(array_keys($vietnameseMap), array_values($vietnameseMap), $str);
        if (function_exists('iconv')) {
            $trans = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $str);
            if (is_string($trans) && $trans !== '') {
                $str = $trans;
            }
        }
        $str = (string) preg_replace('/[^a-z0-9]+/', '-', strtolower($str));
        return trim($str, '-');
    }
}
