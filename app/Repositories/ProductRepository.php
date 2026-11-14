<?php

declare(strict_types=1);

final class ProductRepository extends BaseRepository
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function all(): array
    {
        $sql = "
            SELECT p.id, p.sku, p.name, p.slug, p.primary_image AS image,
                   p.short_description, p.full_description, p.storage_advice, p.target_audience,
                   p.display_order, p.is_featured, p.is_rare, p.is_active,
                   COALESCE(t_type.name, 'WINE') AS category_label,
                   COALESCE(t_type.slug, 'wine') AS category_slug,
                   CASE WHEN t_type.slug = 'bo-qua-tang' THEN 'gift' ELSE 'wine' END AS type,
                   t_prod.name AS producer,
                   t_country.name AS country,
                   t_region.name AS region,
                   t_class.name AS classification,
                   COALESCE(v.price, 0) AS price,
                   v.original_price,
                   v.vintage_year AS vintage,
                   v.alcohol_abv AS abv,
                   COALESCE(v.volume, '750ml') AS volume,
                   COALESCE(v.color, '') AS taste_color,
                   COALESCE(v.aroma, '') AS taste_aroma,
                   COALESCE(v.palate, '') AS taste_palate,
                   COALESCE(v.finish, '') AS taste_finish,
                   COALESCE(v.in_stock, 1) AS in_stock
            FROM products p
            LEFT JOIN taxonomies t_type ON p.wine_type_id = t_type.id
            LEFT JOIN taxonomies t_prod ON p.producer_id = t_prod.id
            LEFT JOIN taxonomies t_country ON p.country_id = t_country.id
            LEFT JOIN taxonomies t_region ON p.region_id = t_region.id
            LEFT JOIN taxonomies t_class ON p.classification_id = t_class.id
            LEFT JOIN product_vintages v ON v.id = (
                SELECT pv.id FROM product_vintages pv
                WHERE pv.product_id = p.id AND pv.is_active = 1
                ORDER BY pv.vintage_year DESC, pv.id ASC
                LIMIT 1
            )
            WHERE p.is_active = 1
            ORDER BY p.display_order ASC, p.id ASC
        ";

        $rows = $this->fetchAll($sql);
        return array_map([$this, 'formatProduct'], $rows);
    }

    public function findBySlug(string $slug): ?array
    {
        $sql = "
            SELECT p.id, p.sku, p.name, p.slug, p.primary_image AS image,
                   p.short_description, p.full_description, p.storage_advice, p.target_audience,
                   p.display_order, p.is_featured, p.is_rare, p.is_active,
                   COALESCE(t_type.name, 'WINE') AS category_label,
                   COALESCE(t_type.slug, 'wine') AS category_slug,
                   CASE WHEN t_type.slug = 'bo-qua-tang' THEN 'gift' ELSE 'wine' END AS type,
                   t_prod.name AS producer,
                   t_country.name AS country,
                   t_region.name AS region,
                   t_class.name AS classification,
                   COALESCE(v.price, 0) AS price,
                   v.original_price,
                   v.vintage_year AS vintage,
                   v.alcohol_abv AS abv,
                   COALESCE(v.volume, '750ml') AS volume,
                   COALESCE(v.color, '') AS taste_color,
                   COALESCE(v.aroma, '') AS taste_aroma,
                   COALESCE(v.palate, '') AS taste_palate,
                   COALESCE(v.finish, '') AS taste_finish,
                   COALESCE(v.in_stock, 1) AS in_stock
            FROM products p
            LEFT JOIN taxonomies t_type ON p.wine_type_id = t_type.id
            LEFT JOIN taxonomies t_prod ON p.producer_id = t_prod.id
            LEFT JOIN taxonomies t_country ON p.country_id = t_country.id
            LEFT JOIN taxonomies t_region ON p.region_id = t_region.id
            LEFT JOIN taxonomies t_class ON p.classification_id = t_class.id
            LEFT JOIN product_vintages v ON v.id = (
                SELECT pv.id FROM product_vintages pv
                WHERE pv.product_id = p.id AND pv.is_active = 1
                ORDER BY pv.vintage_year DESC, pv.id ASC
                LIMIT 1
            )
            WHERE p.is_active = 1 AND p.slug = :slug
            LIMIT 1
        ";

        $row = $this->fetch($sql, ['slug' => $slug]);
        return $row !== null ? $this->formatProduct($row) : null;
    }

    public function findMany(array $slugs): array
    {
        if (empty($slugs)) {
            return [];
        }

        $result = [];
        foreach ($slugs as $slug) {
            $product = $this->findBySlug($slug);
            if ($product !== null) {
                $result[] = $product;
            }
        }
        return $result;
    }

    public function forCategory(array $category): array
    {
        if (!empty($category['product_slugs'])) {
            return $this->findMany($category['product_slugs']);
        }

        $slug = $category['slug'] ?? '';
        if ($slug === '' || $slug === 'all' || $slug === 'san-pham') {
            return $this->all();
        }

        $sql = "
            SELECT p.id, p.sku, p.name, p.slug, p.primary_image AS image,
                   p.short_description, p.full_description, p.storage_advice, p.target_audience,
                   p.display_order, p.is_featured, p.is_rare, p.is_active,
                   COALESCE(t_type.name, 'WINE') AS category_label,
                   COALESCE(t_type.slug, 'wine') AS category_slug,
                   CASE WHEN t_type.slug = 'bo-qua-tang' THEN 'gift' ELSE 'wine' END AS type,
                   t_prod.name AS producer,
                   t_country.name AS country,
                   t_region.name AS region,
                   t_class.name AS classification,
                   COALESCE(v.price, 0) AS price,
                   v.original_price,
                   v.vintage_year AS vintage,
                   v.alcohol_abv AS abv,
                   COALESCE(v.volume, '750ml') AS volume,
                   COALESCE(v.color, '') AS taste_color,
                   COALESCE(v.aroma, '') AS taste_aroma,
                   COALESCE(v.palate, '') AS taste_palate,
                   COALESCE(v.finish, '') AS taste_finish,
                   COALESCE(v.in_stock, 1) AS in_stock
            FROM products p
            LEFT JOIN taxonomies t_type ON p.wine_type_id = t_type.id
            LEFT JOIN taxonomies t_prod ON p.producer_id = t_prod.id
            LEFT JOIN taxonomies t_country ON p.country_id = t_country.id
            LEFT JOIN taxonomies t_region ON p.region_id = t_region.id
            LEFT JOIN taxonomies t_class ON p.classification_id = t_class.id
            LEFT JOIN product_vintages v ON v.id = (
                SELECT pv.id FROM product_vintages pv
                WHERE pv.product_id = p.id AND pv.is_active = 1
                ORDER BY pv.vintage_year DESC, pv.id ASC
                LIMIT 1
            )
            WHERE p.is_active = 1
              AND (t_type.slug = :slug OR t_country.slug = :slug OR t_prod.slug = :slug OR t_region.slug = :slug)
            ORDER BY p.display_order ASC, p.id ASC
        ";

        $rows = $this->fetchAll($sql, ['slug' => $slug]);
        return array_map([$this, 'formatProduct'], $rows);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function vintagesForProduct(array $product): array
    {
        if (empty($product['id'])) {
            return [];
        }

        $sql = "
            SELECT id, product_id, vintage_year AS year, alcohol_abv AS abv, price,
                   volume, color, aroma, palate, finish, in_stock
            FROM product_vintages
            WHERE product_id = :pid AND is_active = 1
            ORDER BY vintage_year DESC
        ";
        $rows = $this->fetchAll($sql, ['pid' => (int) $product['id']]);
        $defaultClassification = (string) ($product['classification'] ?? '');

        return array_map(static function (array $row) use ($defaultClassification): array {
            $alcoholStr = isset($row['abv']) && $row['abv'] !== null
                ? str_replace('.', ',', (string) $row['abv']) . '%'
                : '';
            return [
                'id'             => (int) $row['id'],
                'year'           => (string) $row['year'],
                'alcohol'        => $alcoholStr,
                'classification' => $defaultClassification,
                'price'          => (int) ($row['price'] ?? 0),
                'volume'         => (string) ($row['volume'] ?? '750 ml'),
                'color'          => (string) ($row['color'] ?? ''),
                'aroma'          => (string) ($row['aroma'] ?? ''),
                'palate'         => (string) ($row['palate'] ?? ''),
                'finish'         => (string) ($row['finish'] ?? ''),
                'in_stock'       => (bool) ($row['in_stock'] ?? 1),
            ];
        }, $rows);
    }

    /**
     * @return array<int, array{0: string, 1: string}>
     */
    public function faqs(): array
    {
        $rows = $this->fetchAll('SELECT question_template, answer_template FROM faqs WHERE is_active = 1 ORDER BY display_order ASC, id ASC');
        return array_map(
            static fn (array $r): array => [(string) $r['question_template'], (string) $r['answer_template']],
            $rows
        );
    }

    /**
     * @return array<int, array{score: int, name: string, quote: string}>
     */
    public function reviewsForProduct(array $product): array
    {
        if (empty($product['id'])) {
            return [];
        }

        $sql = 'SELECT score, expert_name AS name, quote FROM expert_reviews WHERE product_id = :pid AND is_active = 1 ORDER BY display_order ASC, id ASC';
        $rows = $this->fetchAll($sql, ['pid' => (int) $product['id']]);
        return array_map(static fn (array $r): array => [
            'score' => (int) ($r['score'] ?? 0),
            'name'  => (string) ($r['name'] ?? ''),
            'quote' => (string) ($r['quote'] ?? ''),
        ], $rows);
    }

    /**
     * @return array<int, array{0: string, 1: string, 2: string}>
     */
    public function commitments(): array
    {
        return [
            ['truck', 'Giao hàng an toàn', 'Đóng gói chỉn chu, giao nhanh tận nơi.'],
            ['glass', 'Tư vấn chuyên nghiệp', 'Chọn chai vang đúng gu và mục đích.'],
            ['shield', 'Cam kết chính hãng', 'Nguồn gốc minh bạch, đầy đủ chứng nhận.'],
            ['tag', 'Giá trị xứng đáng', 'Mức giá cạnh tranh, ưu đãi thành viên.'],
            ['gift', 'Quà tặng tinh tế', 'Hộp quà sang trọng gửi trao lời chúc.'],
            ['headset', 'Đồng hành tận tâm', 'Hỗ trợ khách hàng trước và sau mua hàng.'],
        ];
    }

    private function formatProduct(array $row): array
    {
        $origin = implode(', ', array_filter([$row['region'] ?? '', $row['country'] ?? '']));
        $alcoholStr = isset($row['abv']) && $row['abv'] !== null
            ? str_replace('.', ',', (string) $row['abv']) . '%'
            : '';

        return [
            'id'                => (int) $row['id'],
            'sku'               => (string) $row['sku'],
            'name'              => (string) $row['name'],
            'slug'              => (string) $row['slug'],
            'aliases'           => [(string) $row['slug']],
            'image'             => (string) $row['image'],
            'price'             => (int) ($row['price'] ?? 0),
            'original_price'    => isset($row['original_price']) ? (int) $row['original_price'] : null,
            'type'              => (string) ($row['type'] ?? 'wine'),
            'category_label'    => (string) ($row['category_label'] ?? 'WINE'),
            'category_slug'     => (string) ($row['category_slug'] ?? 'wine'),
            'producer'          => (string) ($row['producer'] ?? ''),
            'country'           => (string) ($row['country'] ?? ''),
            'region'            => (string) ($row['region'] ?? ''),
            'origin'            => $origin,
            'classification'    => (string) ($row['classification'] ?? ''),
            'grape'             => '',
            'vintage'           => (string) ($row['vintage'] ?? 'NV'),
            'abv'               => $alcoholStr,
            'volume'            => (string) ($row['volume'] ?? '750ml'),
            'in_stock'          => (bool) ($row['in_stock'] ?? 1),
            'is_featured'       => (bool) ($row['is_featured'] ?? 0),
            'is_rare'           => (bool) ($row['is_rare'] ?? 0),
            'short_description' => (string) ($row['short_description'] ?? ''),
            'full_description'  => (string) ($row['full_description'] ?? ''),
            'storage_advice'    => (string) ($row['storage_advice'] ?? ''),
            'target_audience'   => (string) ($row['target_audience'] ?? ''),
            'display_order'     => (int) ($row['display_order'] ?? 0),
        ];
    }
}
