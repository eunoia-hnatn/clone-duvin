<?php
/**
 * Front Controller - DangTau Whisky
 * Điểm vào duy nhất của toàn bộ ứng dụng (MVC Entry Point)
 */

define('ROOT_PATH', __DIR__);
define('APP_PATH',  ROOT_PATH . '/app');
define('VIEW_PATH', APP_PATH  . '/views');

// ── Helpers ──────────────────────────────────────────────────────────────────
function loadController(string $file): void
{
    require APP_PATH . '/controllers/' . $file;
}

// ── Lấy URI sạch (bỏ query string, bỏ trailing slash) ────────────────────────
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$uri = rtrim($uri, '/') ?: '/';

// ── Route table (pattern → [controller_file, method, param_index|null]) ──────
//    Thứ tự quan trọng: đặt route cụ thể trước route động
$routes = [

    // ── Trang chủ ────────────────────────────────────────────────────────────
    ['#^/$#',                                   'HomeController.php',    'index',    null],
    ['#^/home$#',                               'HomeController.php',    'index',    null],

    // ── Danh sách sản phẩm ───────────────────────────────────────────────────
    ['#^/san-pham$#',                           'ProductController.php', 'index',    null],

    // ── Chi tiết sản phẩm: /san-pham/{slug} ──────────────────────────────────
    ['#^/san-pham/([a-z0-9\-]+)$#',            'ProductController.php', 'show',     1],

    // ── Danh mục sản phẩm: /danh-muc/{slug} (có thể có sub: /danh-muc/a/b) ──
    ['#^/danh-muc/([a-z0-9\-/]+)$#',           'ProductController.php', 'category', 1],

    // ── Trang tĩnh ───────────────────────────────────────────────────────────
    ['#^/ve-dangtau-whisky$#',                  'PageController.php',    'about',    null],
    ['#^/ve-nha-sang-lap$#',                    'PageController.php',    'founder',  null],
    ['#^/kien-thuc-whisky$#',                   'PageController.php',    'blog',     null],
];

// ── Dispatch ──────────────────────────────────────────────────────────────────
$matched = false;

foreach ($routes as [$pattern, $controllerFile, $method, $paramGroup]) {
    if (preg_match($pattern, $uri, $matches)) {
        $matched = true;

        // Controller file tồn tại?
        $controllerPath = APP_PATH . '/controllers/' . $controllerFile;
        if (!file_exists($controllerPath)) {
            http_response_code(500);
            echo "<h1>500 – Controller <code>$controllerFile</code> chưa được tạo.</h1>";
            exit;
        }

        require $controllerPath;

        // Lấy tên class từ tên file (bỏ .php)
        $className = str_replace('.php', '', $controllerFile);
        $controller = new $className();

        // Gọi method với hoặc không có param
        if ($paramGroup !== null && isset($matches[$paramGroup])) {
            $controller->$method($matches[$paramGroup]);
        } else {
            $controller->$method();
        }

        break;
    }
}

// ── 404 ──────────────────────────────────────────────────────────────────────
if (!$matched) {
    http_response_code(404);
    $pageTitle = '404 – Trang không tồn tại | DangTau Whisky';
    // Hiển thị layout 404 nếu có, hoặc fallback HTML
    $layout404 = APP_PATH . '/views/404.php';
    if (file_exists($layout404)) {
        require $layout404;
    } else {
        echo '<!DOCTYPE html><html lang="vi"><head><meta charset="UTF-8">
              <title>404 | DangTau Whisky</title></head><body>
              <h1>404 – Trang không tồn tại</h1>
              <p><a href="/">← Về trang chủ</a></p>
              </body></html>';
    }
}
