<?php

declare(strict_types=1);

/**
 * BaseRepository
 * Cung cấp kết nối PDO và các hàm truy vấn CSDL chuẩn Prepared Statements.
 */
abstract class BaseRepository
{
    protected function db(): PDO
    {
        return Database::connection();
    }

    protected function query(string $sql, array $params = []): PDOStatement
    {
        return Database::query($sql, $params);
    }

    protected function fetch(string $sql, array $params = []): ?array
    {
        return Database::fetch($sql, $params);
    }

    protected function fetchAll(string $sql, array $params = []): array
    {
        return Database::fetchAll($sql, $params);
    }

    protected function fetchSetting(string $key, string $default = ''): string
    {
        $row = $this->fetch('SELECT `value` FROM `settings` WHERE `key` = :key LIMIT 1', ['key' => $key]);
        if ($row === null || $row['value'] === null) {
            return $default;
        }
        return (string) $row['value'];
    }

    /**
     * @param array<mixed> $default
     * @return array<mixed>
     */
    protected function fetchJsonSetting(string $key, array $default = []): array
    {
        $raw = $this->fetchSetting($key);
        if ($raw === '') {
            return $default;
        }
        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : $default;
    }
}

