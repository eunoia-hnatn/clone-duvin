<?php

declare(strict_types=1);

final class ArticleRepository extends FixtureRepository
{
    public function all(): array
    {
        return $this->load('articles')['items'];
    }

    public function categories(): array
    {
        return $this->load('articles')['categories'];
    }
    public function findBySlug(string $slug): ?array
    {
        foreach ($this->all() as $article) {
            $path = parse_url($article['url'], PHP_URL_PATH);
            if (is_string($path) && basename(rtrim($path, '/')) === $slug) {
                return $article;
            }
        }
        return null;
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
            'page' => $page,
            'pages' => $pages,
            'total' => count($articles),
        ];
    }
}
