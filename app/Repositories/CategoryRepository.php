<?php

declare(strict_types=1);

final class CategoryRepository extends BaseRepository
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public function all(): array
    {
        $rows = $this->fetchAll("
            SELECT t.id, t.name AS title, t.slug, t.description, t.type,
                   t.image_url, t.display_order, t.is_active
            FROM taxonomies t
            WHERE t.is_active = 1 AND t.type IN ('wine_type', 'country')
            ORDER BY t.display_order ASC, t.id ASC
        ");

        $result = [];
        foreach ($rows as $row) {
            $slug = (string) $row['slug'];
            $result[$slug] = $this->formatCategory($row);
        }
        return $result;
    }

    public function findBySlug(string $path): ?array
    {
        $slug = trim($path, '/');
        $segments = explode('/', $slug);
        $lastSlug = end($segments);

        $row = $this->fetch("
            SELECT t.id, t.name AS title, t.slug, t.description, t.type,
                   t.image_url, t.display_order, t.is_active
            FROM taxonomies t
            WHERE t.is_active = 1 AND (t.slug = :slug OR t.slug = :lastSlug)
            LIMIT 1
        ", ['slug' => $slug, 'lastSlug' => $lastSlug]);

        if ($row !== null) {
            return $this->formatCategory($row);
        }

        if ($slug === 'all' || $slug === 'san-pham' || $slug === 'wine') {
            return $this->overview();
        }

        return null;
    }

    public function overview(): array
    {
        return [
            'title' => 'Tất Cả Sản Phẩm',
            'slug'  => 'san-pham',
            'desc'  => 'Khám phá bộ sưu tập rượu vang và quà tặng cao cấp tại Duvin.',
            'product_slugs' => [],
        ];
    }

    /**
     * @return array<int, array{label: string, url: string, slug: string}>
     */
    public function navigation(): array
    {
        $types = $this->fetchAll("
            SELECT name, slug
            FROM taxonomies
            WHERE type = 'wine_type' AND is_active = 1
            ORDER BY display_order ASC, id ASC
        ");

        return array_map(static fn (array $t): array => [
            'label' => (string) $t['name'],
            'url'   => '/danh-muc/' . $t['slug'],
            'slug'  => (string) $t['slug'],
            'path'  => (string) $t['slug'],
        ], $types);
    }

    private function formatCategory(array $row): array
    {
        $slug = (string) $row['slug'];
        $pRows = $this->fetchAll("
            SELECT p.slug
            FROM products p
            LEFT JOIN taxonomies t ON (p.wine_type_id = t.id OR p.country_id = t.id)
            WHERE p.is_active = 1 AND t.slug = :slug
        ", ['slug' => $slug]);

        $productSlugs = array_column($pRows, 'slug');

        return [
            'id'            => (int) $row['id'],
            'title'         => (string) $row['title'],
            'slug'          => $slug,
            'desc'          => (string) ($row['description'] ?? $row['desc'] ?? ''),
            'type'          => (string) $row['type'],
            'product_slugs' => $productSlugs,
        ];
    }
}
