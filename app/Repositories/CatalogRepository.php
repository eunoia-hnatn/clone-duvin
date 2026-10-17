<?php

declare(strict_types=1);

final class CatalogRepository extends FixtureRepository
{
    public function filters(): array
    {
        return $this->load('catalog')['filters'];
    }

    public function relatedSlugs(): array
    {
        return $this->load('catalog')['related_slugs'];
    }

    public function priceNote(): string
    {
        return $this->load('catalog')['price_note'];
    }

    public function detail(): array
    {
        return $this->load('product_detail');
    }
}
