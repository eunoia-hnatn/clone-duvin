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
}

