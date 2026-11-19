<?php

declare(strict_types=1);

/**
 * RecommendationService — Thuật toán gợi ý sản phẩm tương tự (Rule-based Similarity Matrix).
 *
 * Trọng số theo spec FR-07:
 *   - Cùng Giống nho (product_vintage_grapes): +50 điểm
 *   - Cùng Phân hạng / Đẳng cấp (classification_id): +30 điểm
 *   - Cùng Nhà sản xuất (producer_id): +20 điểm
 *
 * Hard Filter:
 *   - Loại bỏ chính sản phẩm đang xem.
 *   - Loại bỏ sản phẩm hết hàng (không có niên vụ active nào in_stock = 1).
 *   - Lấy tối đa 4–8 sản phẩm có điểm cao nhất.
 */
final class RecommendationService extends BaseRepository
{
    public const WEIGHT_GRAPE = 50;
    public const WEIGHT_CLASSIFICATION = 30;
    public const WEIGHT_PRODUCER = 20;

    /**
     * @param array<string, mixed> $currentProduct
     * @return array<int, array<string, mixed>>
     */
    public function forProduct(array $currentProduct, ProductRepository $products, int $limit = 8): array
    {
        $currentId = (int) ($currentProduct['id'] ?? 0);
        if ($currentId <= 0) {
            return [];
        }

        $limit = max(4, min(8, $limit));

        $currentMeta = $this->fetch(
            'SELECT id, producer_id, classification_id FROM products WHERE id = :id LIMIT 1',
            ['id' => $currentId]
        );
        if ($currentMeta === null) {
            return [];
        }

        $currentProducerId = (int) ($currentMeta['producer_id'] ?? 0);
        $currentClassId = (int) ($currentMeta['classification_id'] ?? 0);
        $currentGrapes = $this->grapeIdsForProduct($currentId);

        // Chỉ lấy ứng viên đang active, khác SP hiện tại và còn ít nhất 1 niên vụ còn hàng (in_stock = 1)
        $candidates = $this->fetchAll(
            'SELECT p.id, p.slug, p.producer_id, p.classification_id, p.is_featured, p.display_order
             FROM products p
             WHERE p.is_active = 1
               AND p.id != :current_id
               AND EXISTS (
                   SELECT 1 FROM product_vintages pv
                   WHERE pv.product_id = p.id AND pv.is_active = 1 AND pv.in_stock = 1
               )',
            ['current_id' => $currentId]
        );

        if ($candidates === []) {
            return [];
        }

        $grapeMap = $currentGrapes !== [] ? $this->allInStockProductGrapes() : [];

        $scored = [];
        foreach ($candidates as $candidate) {
            $cid = (int) $candidate['id'];
            $score = 0;

            if ($currentGrapes !== [] && !empty($grapeMap[$cid])) {
                if (array_intersect($currentGrapes, $grapeMap[$cid]) !== []) {
                    $score += self::WEIGHT_GRAPE;
                }
            }

            $candClassId = (int) ($candidate['classification_id'] ?? 0);
            if ($currentClassId > 0 && $candClassId === $currentClassId) {
                $score += self::WEIGHT_CLASSIFICATION;
            }

            $candProducerId = (int) ($candidate['producer_id'] ?? 0);
            if ($currentProducerId > 0 && $candProducerId === $currentProducerId) {
                $score += self::WEIGHT_PRODUCER;
            }

            $scored[] = [
                'slug'          => (string) $candidate['slug'],
                'score'         => $score,
                'is_featured'   => (int) ($candidate['is_featured'] ?? 0),
                'display_order' => (int) ($candidate['display_order'] ?? 0),
                'id'            => $cid,
            ];
        }

        usort($scored, static function (array $a, array $b): int {
            return ($b['score'] <=> $a['score'])
                ?: ($b['is_featured'] <=> $a['is_featured'])
                ?: ($a['display_order'] <=> $b['display_order'])
                ?: ($a['id'] <=> $b['id']);
        });

        $topSlugs = array_column(array_slice($scored, 0, $limit), 'slug');
        return $products->findMany($topSlugs);
    }

    /**
     * @return array<int, int>
     */
    private function grapeIdsForProduct(int $productId): array
    {
        $rows = $this->fetchAll(
            'SELECT DISTINCT pvg.grape_id
             FROM product_vintages pv
             INNER JOIN product_vintage_grapes pvg ON pvg.vintage_id = pv.id
             WHERE pv.product_id = :pid AND pv.is_active = 1',
            ['pid' => $productId]
        );
        return array_map(static fn (array $r): int => (int) $r['grape_id'], $rows);
    }

    /**
     * @return array<int, array<int, int>>
     */
    private function allInStockProductGrapes(): array
    {
        $rows = $this->fetchAll(
            'SELECT DISTINCT pv.product_id, pvg.grape_id
             FROM product_vintages pv
             INNER JOIN product_vintage_grapes pvg ON pvg.vintage_id = pv.id
             WHERE pv.is_active = 1 AND pv.in_stock = 1'
        );

        $map = [];
        foreach ($rows as $row) {
            $map[(int) $row['product_id']][] = (int) $row['grape_id'];
        }
        return $map;
    }
}

