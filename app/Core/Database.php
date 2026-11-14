<?php

declare(strict_types=1);

/**
 * Database Core Wrapper
 * Quản lý kết nối PDO chuẩn hóa Singleton (MySQL trên Production / SQLite trên Local).
 * Hỗ trợ Prepared Statements, Transaction và tối ưu cho Shared Hosting.
 */
class Database
{
    private static ?PDO $instance = null;

    /**
     * Lấy kết nối PDO duy nhất (Lazy Loading)
     */
    public static function connection(): PDO
    {
        if (self::$instance === null) {
            $host = Config::get('DB_HOST', '127.0.0.1');
            $port = Config::get('DB_PORT', '3306');
            $database = Config::get('DB_NAME', '');
            $username = Config::get('DB_USER', '');
            $password = Config::get('DB_PASS', '');

            // 1. Kết nối MySQL khi có cấu hình (luôn ưu tiên cho Production & staging)
            if ($host !== '' && $database !== '' && $host !== 'sqlite') {
                try {
                    $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $database);
                    $options = [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES   => false,
                        PDO::ATTR_TIMEOUT            => 10,
                    ];
                    $pdo = new PDO($dsn, $username, $password, $options);
                    $pdo->exec("SET NAMES utf8mb4");
                    self::$instance = $pdo;
                    return self::$instance;
                } catch (Throwable $e) {
                    // Trên môi trường production, ném thẳng exception lỗi kết nối MySQL để xử lý, không fallback bừa bãi
                    if (Config::get('APP_ENV') === 'production') {
                        throw new RuntimeException('MySQL connection failed on production: ' . $e->getMessage(), (int)$e->getCode(), $e);
                    }
                    error_log('[Database Notice] MySQL unavailable on local (' . $e->getMessage() . '), switching to SQLite local.');
                }
            }

            // 2. Kết nối SQLite Database cho môi trường local dev (nếu không có MySQL)
            try {
                $sqlitePath = dirname(__DIR__, 2) . '/database/duvin.sqlite';
                $sqliteDir = dirname($sqlitePath);
                if (!is_dir($sqliteDir)) {
                    @mkdir($sqliteDir, 0777, true);
                }
                self::$instance = new PDO('sqlite:' . $sqlitePath, null, null, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (Throwable $sqliteErr) {
                throw new RuntimeException('Database connection failed: ' . $sqliteErr->getMessage(), (int)$sqliteErr->getCode(), $sqliteErr);
            }
        }

        return self::$instance;
    }

    /**
     * Alias cho connection() để tương thích code cũ
     */
    public static function getInstance(): PDO
    {
        return self::connection();
    }

    /**
     * Cho phép gán hoặc reset kết nối PDO (tiện cho Unit Test & Mocking)
     */
    public static function setConnection(?PDO $pdo): void
    {
        self::$instance = $pdo;
    }

    /**
     * Kiểm tra trạng thái kết nối
     */
    public static function isConnected(): bool
    {
        try {
            return self::connection() instanceof PDO;
        } catch (Throwable) {
            return false;
        }
    }

    /**
     * Chuẩn bị và thực thi câu lệnh SQL với tham số an toàn
     */
    public static function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = self::connection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Lấy 1 bản ghi đầu tiên
     */
    public static function fetch(string $sql, array $params = []): ?array
    {
        $stmt = self::query($sql, $params);
        $result = $stmt->fetch();
        return $result === false ? null : $result;
    }

    /**
     * Lấy toàn bộ danh sách bản ghi
     */
    public static function fetchAll(string $sql, array $params = []): array
    {
        return self::query($sql, $params)->fetchAll();
    }

    /**
     * Thực thi câu lệnh INSERT/UPDATE/DELETE và trả về số dòng bị ảnh hưởng
     */
    public static function execute(string $sql, array $params = []): int
    {
        return self::query($sql, $params)->rowCount();
    }

    /**
     * Lấy ID vừa được tạo từ auto-increment
     */
    public static function lastInsertId(): string
    {
        return (string) self::connection()->lastInsertId();
    }

    /**
     * Bắt đầu một Transaction
     */
    public static function beginTransaction(): bool
    {
        return self::connection()->beginTransaction();
    }

    /**
     * Xác nhận Transaction
     */
    public static function commit(): bool
    {
        return self::connection()->commit();
    }

    /**
     * Hoàn tác Transaction khi có lỗi
     */
    public static function rollBack(): bool
    {
        return self::connection()->rollBack();
    }
}
