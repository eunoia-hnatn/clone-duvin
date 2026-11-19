<?php

declare(strict_types=1);

final class HomeRepository extends BaseRepository
{
    /**
     * @return array<string, mixed>
     */
    public function content(): array
    {
        return $this->loadGroup('content');
    }

    /**
     * @return array<string, mixed>
     */
    public function presentation(): array
    {
        return $this->loadGroup('presentation');
    }

    /**
     * @return array<string, mixed>
     */
    private function loadGroup(string $group): array
    {
        $rows = $this->fetchAll(
            'SELECT section_key, payload
             FROM home_sections
             WHERE section_group = :grp AND is_active = 1
             ORDER BY display_order ASC, id ASC',
            ['grp' => $group]
        );

        $result = [];
        foreach ($rows as $row) {
            $decoded = json_decode((string) ($row['payload'] ?? ''), true);
            $result[(string) $row['section_key']] = is_array($decoded) ? $decoded : [];
        }

        return $result;
    }
}
