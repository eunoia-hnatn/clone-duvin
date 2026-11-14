<?php

declare(strict_types=1);

final class ArticleRepository extends BaseRepository
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function all(): array
    {
        $rows = $this->fetchAll("
            SELECT a.id, a.title, a.slug, a.excerpt, a.content, a.image_url, a.published_at,
                   c.name AS category_name, c.slug AS category_slug
            FROM articles a
            LEFT JOIN article_categories c ON a.category_id = c.id
            WHERE a.is_published = 1
            ORDER BY a.published_at DESC, a.id DESC
        ");

        return array_map([$this, 'formatArticle'], $rows);
    }

    public function findBySlug(string $slug): ?array
    {
        $cleanSlug = trim($slug, '/');
        $row = $this->fetch("
            SELECT a.id, a.title, a.slug, a.excerpt, a.content, a.image_url, a.published_at,
                   c.name AS category_name, c.slug AS category_slug
            FROM articles a
            LEFT JOIN article_categories c ON a.category_id = c.id
            WHERE a.is_published = 1 AND a.slug = :slug
            LIMIT 1
        ", ['slug' => $cleanSlug]);

        if ($row === null) {
            return null;
        }

        return $this->formatArticle($row);
    }

    public function paginate(int $page, int $perPage = 3): array
    {
        if ($page < 1 || $perPage < 1) {
            throw new InvalidArgumentException('Pagination values must be positive.');
        }

        $articles = $this->all();
        $pages = max(1, (int) ceil(count($articles) / $perPage));

        return [
            'items' => $page <= $pages ? array_slice($articles, ($page - 1) * $perPage, $perPage) : [],
            'page'  => $page,
            'pages' => $pages,
            'total' => count($articles),
        ];
    }

    /**
     * @return array<int, array{label: string, url: string, count: int, class: string}>
     */
    public function categories(): array
    {
        $rows = $this->fetchAll("
            SELECT c.id, c.name, c.slug, COUNT(a.id) AS article_count
            FROM article_categories c
            LEFT JOIN articles a ON a.category_id = c.id AND a.is_published = 1
            GROUP BY c.id
            ORDER BY c.display_order ASC, c.id ASC
        ");

        return array_map(static fn (array $r): array => [
            'id'    => (int) $r['id'],
            'label' => (string) $r['name'],
            'url'   => '/danh-muc/' . $r['slug'] . '/',
            'count' => (int) ($r['article_count'] ?? 0),
            'class' => 'cat-item cat-item-' . (int) $r['id'],
        ], $rows);
    }

    private function formatArticle(array $r): array
    {
        $publishedAt = (string) ($r['published_at'] ?? 'now');
        $timestamp = strtotime($publishedAt) ?: time();

        return [
            'id'            => (int) $r['id'],
            'title'         => (string) $r['title'],
            'slug'          => (string) $r['slug'],
            'url'           => '/blog/' . (string) $r['slug'] . '/',
            'excerpt'       => (string) ($r['excerpt'] ?? ''),
            'content'       => (string) ($r['content'] ?? ''),
            'category'      => (string) ($r['category_name'] ?? 'Wine Basics'),
            'category_slug' => (string) ($r['category_slug'] ?? 'whisky-basics'),
            'date_day'      => date('d', $timestamp),
            'date_month'    => 'Th' . date('n', $timestamp),
            'published_at'  => $publishedAt,
            'image'         => [
                'width'    => '1200',
                'height'   => '800',
                'src'      => (string) $r['image_url'],
                'class'    => 'attachment-medium size-medium wp-post-image',
                'alt'      => (string) $r['title'] . ' | DuVin',
                'title'    => (string) $r['title'] . ' | DuVin',
                'decoding' => 'async',
                'loading'  => 'lazy',
            ],
        ];
    }
}
