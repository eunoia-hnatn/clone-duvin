<?php

declare(strict_types=1);

final class SiteRepository extends FixtureRepository
{
    public function content(): array
    {
        return $this->load('site');
    }
}
