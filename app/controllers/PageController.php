<?php
class PageController
{
    public function about(): void {
        $pageTitle = 'Về Dangtau Whisky | DangTau Whisky';
        require VIEW_PATH . '/about.php';
    }
    public function founder(): void {
        $pageTitle = 'Về nhà sáng lập | DangTau Whisky';
        require VIEW_PATH . '/founder.php';
    }
    public function blog(?string $slug = null): void {
        $heading = 'Kiến thức Whisky';
        if ($slug !== null) {
            $matches = array_values(array_filter(sitemap()['blogs'], fn($item) => $item['url'] === '/kien-thuc-whisky/' . $slug));
            if (!$matches) { notFound(); return; }
            $heading = $matches[0]['label'];
        }
        $pageTitle = $heading . ' | DangTau Whisky';
        if ($slug === null) require VIEW_PATH . '/blog.php';
        else {
            $message = 'Trang khung demo — nội dung chuyên mục đang cập nhật. Dữ liệu Blog sẽ được hoàn thiện ở chặng 2.';
            require VIEW_PATH . '/placeholder.php';
        }
    }
    public function services(): void {
        $heading = 'Dịch vụ/Cá nhân hóa';
        $pageTitle = $heading . ' | DangTau Whisky';
        $message = 'Nội dung đang cập nhật';
        require VIEW_PATH . '/placeholder.php';
    }
    public function search(): void {
        $heading = 'Tìm kiếm';
        $pageTitle = $heading . ' | DangTau Whisky';
        $query = is_string($_GET['q'] ?? null) ? trim($_GET['q']) : '';
        $message = 'Search đang chờ chặng 2. Chưa thực hiện tìm kiếm trong dữ liệu sản phẩm.';
        require VIEW_PATH . '/placeholder.php';
    }
}
