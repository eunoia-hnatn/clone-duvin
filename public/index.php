<?php

declare(strict_types=1);

// Allow PHP's development server to serve files from the public directory.
// The root entry point also supports /assets URLs for existing local setups.
if (PHP_SAPI === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $publicRoot = realpath(__DIR__);
    $file = is_string($path) ? realpath(__DIR__ . '/' . rawurldecode($path)) : false;
    if ($file !== false && is_file($file) && str_starts_with($file, $publicRoot . DIRECTORY_SEPARATOR)
        && !str_starts_with(basename($file), '.') && strtolower(pathinfo($file, PATHINFO_EXTENSION)) !== 'php') {
        if (realpath($_SERVER['DOCUMENT_ROOT'] ?? '') === $publicRoot) {
            return false;
        }
        $types = ['css' => 'text/css', 'js' => 'application/javascript', 'svg' => 'image/svg+xml',
            'woff' => 'font/woff', 'woff2' => 'font/woff2', 'ttf' => 'font/ttf', 'otf' => 'font/otf',
            'txt' => 'text/plain'];
        header('Content-Type: ' . ($types[strtolower(pathinfo($file, PATHINFO_EXTENSION))] ?? mime_content_type($file)));
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'HEAD') {
            readfile($file);
        }
        return;
    }
}

$router = require dirname(__DIR__) . '/bootstrap/app.php';
require ROOT_PATH . '/routes/web.php';

header('Content-Type: text/html; charset=UTF-8');
$isHead = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'HEAD';
if ($isHead) {
    ob_start();
}
try {
    $router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', $_SERVER['REQUEST_URI'] ?? '/');
} finally {
    if ($isHead) {
        ob_end_clean();
    }
}
