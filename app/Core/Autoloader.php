<?php

declare(strict_types=1);

final class Autoloader
{
    private static bool $registered = false;
    private static array $dirs = [];
    private static array $classMap = [
        'BaseController' => '/Core/Controller.php',
    ];

    public static function register(?string $basePath = null): void
    {
        if (self::$registered) {
            return;
        }

        $base = $basePath ?? (defined('APP_PATH') ? APP_PATH : dirname(__DIR__));
        self::$dirs = [
            $base . '/Core',
            $base . '/controllers',
            $base . '/Controllers',
            $base . '/Repositories',
            $base . '/Services',
            $base . '/Middlewares',
            $base . '/Models',
        ];

        spl_autoload_register([self::class, 'load']);
        self::$registered = true;
    }

    public static function load(string $class): void
    {
        $base = defined('APP_PATH') ? APP_PATH : dirname(__DIR__);

        // Check specific class map
        if (isset(self::$classMap[$class])) {
            $file = $base . self::$classMap[$class];
            if (is_file($file)) {
                require_once $file;
                return;
            }
        }

        // 1. Handle PSR-4 style with App\ prefix
        if (str_starts_with($class, 'App\\')) {
            $relative = substr($class, 4);
            $filePath = $base . '/' . str_replace('\\', '/', $relative) . '.php';
            if (is_file($filePath)) {
                require_once $filePath;
                return;
            }
        }

        // 2. Normalize class path for sub-namespaces (e.g. Admin\AuthController)
        $normalized = str_replace('\\', '/', $class);

        // 3. Search in configured app directories
        foreach (self::$dirs as $dir) {
            $file = $dir . '/' . $normalized . '.php';
            if (is_file($file)) {
                require_once $file;
                return;
            }
        }
    }
}
