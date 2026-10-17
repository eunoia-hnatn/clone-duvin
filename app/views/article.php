<?php include __DIR__ . '/layouts/header.php'; ?>
<main id="main" class="page-wrapper">
    <article class="container">
        <nav aria-label="breadcrumbs"><a href="/">Trang chủ</a> / <a href="/kien-thuc-whisky">Wine Knowledge</a></nav>
        <h1><?= e($article['title']) ?></h1>
        <p><?= e($article['category']) ?></p>
        <div class="row">
            <div class="col medium-8 small-12">
                <?php $image = $article['image']; include __DIR__ . '/components/image.php'; ?>
                <p>Nội dung chi tiết bài viết đang được hoàn thiện. Hiện trang hiển thị thông tin giới thiệu từ bản demo.</p>
                <a href="/kien-thuc-whisky" class="button primary">Quay lại danh sách bài viết</a>
            </div>
        </div>
    </article>
</main>
<?php include __DIR__ . '/layouts/footer.php'; ?>
