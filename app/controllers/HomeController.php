<?php
/**
 * HomeController
 * Xử lý trang chủ của DangTau Whisky
 */
class HomeController
{
    public function index(): void
    {
        // Tiêu đề trang — header.php sẽ dùng biến này
        $pageTitle = 'World Class Whisky & Spirit | DangTau Whisky';

        // Load view
        require VIEW_PATH . '/home.php';
    }
}

// Khởi chạy ngay (Front Controller gọi file này trực tiếp)
$controller = new HomeController();
$controller->index();
