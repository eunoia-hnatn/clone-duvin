<?php
/**
 * Master Layout — app/views/layouts/main.php
 *
 * Template bao bọc (HTML shell) dùng chung cho toàn bộ trang Duvin.
 *
 * Cách sử dụng (sau khi BaseController được nâng cấp):
 *   BaseController::render('home', $data)
 *   → Capture output của app/views/home.php vào $content
 *   → Include main.php, truyền $content vào giữa header và footer
 *
 * Biến:
 *   @var string  $content         Nội dung HTML của trang cụ thể (bắt buộc)
 *   @var string  $pageTitle       Tiêu đề trang (mặc định: 'Duvin')
 *   @var string  $metaDescription Mô tả SEO (mặc định: 'Duvin - Fine Wine')
 *   @var string  $bodyClass        CSS class cho thẻ <body>
 *   @var array   $site             Dữ liệu site (menus, settings, contact)
 *   @var array   $meta             Meta tags bổ sung (open graph, canonical, v.v.)
 */
?>
<?php include __DIR__ . '/header.php'; ?>

<!-- ========== PAGE CONTENT ========== -->
<?= $content ?? '' ?>
<!-- ========== /PAGE CONTENT ========== -->

<?php include __DIR__ . '/footer.php'; ?>
