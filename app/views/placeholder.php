<?php require VIEW_PATH . '/layouts/header.php'; ?>
<main class="container demo-page">
    <p><a href="/">Trang chủ</a> / <?= e($heading) ?></p>
    <h1><?= e($heading) ?></h1>
    <p class="demo-notice"><?= e($message) ?></p>
    <?php if (isset($query)): ?>
        <p>Từ khóa đã nhập: <strong><?= e($query ?: '(Trống)') ?></strong></p>
        <?php $searchId = 'page-search'; require VIEW_PATH . '/partials/search.php'; ?>
    <?php elseif (str_starts_with(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/kien-thuc-whisky')): ?>
        <ul class="demo-link-list"><?php renderMenu(sitemap()['blogs'], 'footer'); ?></ul>
    <?php else: ?>
        <a class="button primary" href="#demo-contact" data-demo-contact>Tư vấn</a>
    <?php endif; ?>
    <p><a href="/san-pham">Khám phá sản phẩm</a></p>
</main>
<?php require VIEW_PATH . '/layouts/footer.php'; ?>
