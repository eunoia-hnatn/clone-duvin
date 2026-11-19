<?php

declare(strict_types=1);

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__));
}
if (!defined('APP_PATH')) {
    define('APP_PATH', ROOT_PATH . '/app');
}
if (!defined('VIEW_PATH')) {
    define('VIEW_PATH', APP_PATH . '/views');
}

// 1. Nạp Autoloader & Helpers thiết yếu
require_once APP_PATH . '/Core/Autoloader.php';
require_once APP_PATH . '/Core/helpers.php';

// 2. Kích hoạt Autoloader
Autoloader::register(APP_PATH);

// 3. Nạp cấu hình từ .env
Config::load(ROOT_PATH . '/.env');

// Bật hiển thị lỗi khi debug được bật hoặc qua tham số ?debug=1
if (Config::get('APP_DEBUG') === 'true' || Config::get('APP_DEBUG') === true || isset($_GET['debug'])) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
}

// 4. Khởi tạo Router chính
return new Router(static function (int $status): void {
    (new BaseController())->render('errors/http', ['status' => $status], null);
});
