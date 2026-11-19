<?php

declare(strict_types=1);

final class CatalogRepository extends BaseRepository
{
    /**
     * @return array<int, array{id: string, class: string, title: string, options: array<int, array{label: string, url: string, count: ?int}>}>
     */
    public function filters(): array
    {
        // 1. Producers / Brands
        $producers = $this->fetchAll("
            SELECT t.name, t.slug, COUNT(p.id) AS product_count
            FROM taxonomies t
            LEFT JOIN products p ON p.producer_id = t.id AND p.is_active = 1
            WHERE t.type = 'producer' AND t.is_active = 1
            GROUP BY t.id
            ORDER BY t.display_order ASC, t.name ASC
        ");

        $producerOptions = array_map(static fn (array $p): array => [
            'label' => (string) $p['name'],
            'url'   => '/danh-muc/wine/?filter_brands=' . $p['slug'] . '&query_type_brands=or',
            'count' => (int) ($p['product_count'] ?? 0),
        ], $producers);

        // 2. Countries
        $countries = $this->fetchAll("
            SELECT t.name, t.slug, COUNT(p.id) AS product_count
            FROM taxonomies t
            LEFT JOIN products p ON p.country_id = t.id AND p.is_active = 1
            WHERE t.type = 'country' AND t.is_active = 1
            GROUP BY t.id
            ORDER BY t.display_order ASC, t.name ASC
        ");

        $countryOptions = array_map(static fn (array $c): array => [
            'label' => (string) $c['name'],
            'url'   => '/danh-muc/' . $c['slug'] . '/',
            'count' => (int) ($c['product_count'] ?? 0),
        ], $countries);

        // 3. Price ranges
        $priceOptions = $this->fetchJsonSetting('catalog_price_ranges', []);
        $titles = $this->fetchJsonSetting('catalog_filter_titles', []);

        return [
            [
                'id'      => 'woocommerce_layered_nav-3',
                'class'   => 'widget woocommerce widget_layered_nav woocommerce-widget-layered-nav',
                'title'   => (string) ($titles['producer'] ?? ''),
                'options' => $producerOptions,
            ],
            [
                'id'      => 'woocommerce_layered_nav-4',
                'class'   => 'widget woocommerce widget_layered_nav woocommerce-widget-layered-nav',
                'title'   => (string) ($titles['country'] ?? ''),
                'options' => $countryOptions,
            ],
            [
                'id'      => 'woocommerce_price_filter-3',
                'class'   => 'widget woocommerce widget_price_filter',
                'title'   => (string) ($titles['price'] ?? ''),
                'options' => $priceOptions,
            ],
        ];
    }

    /**
     * @return array<int, string>
     */
    public function relatedSlugs(): array
    {
        $rows = $this->fetchAll("
            SELECT slug
            FROM products
            WHERE is_active = 1
            ORDER BY is_featured DESC, display_order ASC
            LIMIT 4
        ");
        return array_column($rows, 'slug');
    }

    public function priceNote(): string
    {
        return $this->fetchSetting('price_note');
    }

    /**
     * @return array<string, mixed>
     */
    public function detail(): array
    {
        return [
            'price_note' => $this->priceNote(),
        ];
    }
}
