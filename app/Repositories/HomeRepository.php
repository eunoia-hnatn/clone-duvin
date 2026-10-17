<?php

declare(strict_types=1);

final class HomeRepository extends FixtureRepository
{
    public function content(): array
    {
        return $this->load('home');
    }

    public function presentation(): array
    {
        return $this->load('presentation');
    }
}
