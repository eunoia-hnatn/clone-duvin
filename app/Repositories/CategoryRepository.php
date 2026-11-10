<?php

declare(strict_types=1);

final class CategoryRepository extends FixtureRepository
{
    public function all(): array
    {
        return array_values($this->load('categories')['items']);
    }

    public function findBySlug(string $path): ?array
    {
        return $this->load('categories')['items'][$path] ?? null;
    }

    public function overview(): array
    {
        return $this->load('categories')['overview'];
    }

    public function navigation(): array
    {
        return $this->load('categories')['navigation'];
    }
}
