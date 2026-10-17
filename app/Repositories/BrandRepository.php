<?php

declare(strict_types=1);

final class BrandRepository extends FixtureRepository
{
    public function all(): array
    {
        return $this->load('brands');
    }
}
