<?php

declare(strict_types=1);

final class ProductRepository extends FixtureRepository
{
    public function all(): array
    {
        return array_values($this->load('products'));
    }

    public function findBySlug(string $slug): ?array
    {
        $products = $this->load('products');
        if (isset($products[$slug])) {
            return $products[$slug];
        }
        foreach ($products as $product) {
            if (in_array($slug, $product['aliases'], true)) {
                return $product;
            }
        }
        return null;
    }

    public function findMany(array $slugs): array
    {
        $result = [];
        foreach ($slugs as $slug) {
            $product = $this->findBySlug($slug);
            if ($product === null) {
                throw new UnexpectedValueException('Unknown product fixture reference: ' . $slug);
            }
            $result[] = $product;
        }
        return $result;
    }

    public function forCategory(array $category): array
    {
        return $this->findMany($category['product_slugs']);
    }
}
