<?php

declare(strict_types=1);

final class BrandRepository extends BaseRepository
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function all(): array
    {
        $rows = $this->fetchAll("
            SELECT id, name, slug, description, image_url AS logo, display_order
            FROM taxonomies
            WHERE type = 'producer' AND is_active = 1
            ORDER BY display_order ASC, name ASC
        ");

        return array_map(static fn (array $r): array => [
            'id'          => (int) $r['id'],
            'name'        => (string) $r['name'],
            'slug'        => (string) $r['slug'],
            'url'         => '/nha-san-xuat/' . $r['slug'],
            'description' => (string) ($r['description'] ?? ''),
            'logo'        => (string) ($r['logo'] ?? '/assets/images/brand-placeholder.png'),
            'image'       => [
                'src'   => (string) ($r['logo'] ?? '/assets/images/brand-placeholder.png'),
                'alt'   => (string) $r['name'] . ' | DuVin',
                'title' => (string) $r['name'] . ' | DuVin',
            ],
        ], $rows);
    }

    public function findBySlug(string $slug): ?array
    {
        $row = $this->fetch("
            SELECT id, name, slug, description, image_url AS logo, display_order
            FROM taxonomies
            WHERE type = 'producer' AND slug = :slug AND is_active = 1
            LIMIT 1
        ", ['slug' => $slug]);

        if ($row === null) {
            return null;
        }

        return [
            'id'          => (int) $row['id'],
            'name'        => (string) $row['name'],
            'slug'        => (string) $row['slug'],
            'url'         => '/nha-san-xuat/' . $row['slug'],
            'description' => (string) ($row['description'] ?? ''),
            'logo'        => (string) ($row['logo'] ?? '/assets/images/brand-placeholder.png'),
        ];
    }
}
