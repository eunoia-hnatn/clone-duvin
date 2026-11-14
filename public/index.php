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
} catch (Throwable $e) {
    if ($isHead) {
        ob_end_clean();
    }
    http_response_code(500);
    $debug = Config::get('APP_DEBUG') === 'true' || Config::get('APP_DEBUG') === true || isset($_GET['debug']);
    if ($debug) {
        echo '<h1>Application Error (500)</h1>';
        echo '<p><strong>Message:</strong> ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</p>';
        echo '<p><strong>File:</strong> ' . htmlspecialchars($e->getFile(), ENT_QUOTES, 'UTF-8') . ':' . $e->getLine() . '</p>';
        echo '<pre>' . htmlspecialchars($e->getTraceAsString(), ENT_QUOTES, 'UTF-8') . '</pre>';
    } else {
        echo '<!DOCTYPE html><html lang="vi"><head><meta charset="UTF-8"><title>500 | Duvin</title><style>body{font-family:sans-serif;text-align:center;padding:60px 20px;background:#fcf7e8;color:#333;}h1{color:#822a1a;margin-bottom:12px;}p{font-size:16px;color:#666;}code{background:#eee;padding:2px 6px;border-radius:4px;}</style></head><body><h1>Hệ thống đang bảo trì hoặc gặp lỗi kết nối</h1><p>Vui lòng thử lại sau ít phút hoặc thêm <code>?debug=1</code> vào URL để xem thông tin chi tiết.</p></body></html>';
    }
    exit;
} finally {
    if ($isHead) {
        ob_end_clean();
    }
}
