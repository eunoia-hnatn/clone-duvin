<?php
/**
 * PageController
 * Xử lý các trang tĩnh/nội dung của DuVin
 */
class PageController
{
    /**
     * Về DuVin — GET /ve-dangtau-whisky
     */
    public function about(): void
    {
        $pageTitle = 'Về DuVin | DuVin';
        require VIEW_PATH . '/about.php';
    }

    /**
     * Về nhà sáng lập — GET /ve-nha-sang-lap
     */
    public function founder(): void
    {
        $pageTitle = 'Về Nhà Sáng Lập | DuVin';
        require VIEW_PATH . '/founder.php';
    }

    /**
     * Kiến thức Whisky — GET /kien-thuc-whisky
     */
    public function blog(): void
    {
        $pageTitle = 'Kiến Thức Whisky | DuVin';
        require VIEW_PATH . '/blog.php';
    }

    /**
     * Trắc nghiệm Whisky — GET /trac-nghiem-whisky
     */
    public function quiz(): void
    {
        $pageTitle = 'Trắc Nghiệm Whisky | DuVin';
        require VIEW_PATH . '/quiz.php';
    }

    /**
     * Khắc chai cá nhân hóa — GET /khac-chai-ca-nhan-hoa
     */
    public function engraving(): void
    {
        $pageTitle = 'Khắc Chai Cá Nhân Hóa | DuVin';
        require VIEW_PATH . '/engraving.php';
    }
}
