<?php

/** @var Router $router */
$home = new HomeController(new HomeRepository(), new BrandRepository(), new SiteRepository());
$products = new ProductController(new ProductRepository(), new CategoryRepository(), new CatalogRepository(), new SiteRepository());
$pages = new PageController(new SiteRepository(), new ArticleRepository());
$slug = '[a-z0-9-]+';
$categoryPath = '[a-z0-9-]+(?:/[a-z0-9-]+)*';

$router->get('/', [$home, 'index']);
$router->get('/home', [$home, 'index']);
$router->get('/san-pham', [$products, 'index']);
// Legacy demo links requested a non-existent second product page.
// Preserve filter query parameters; filtering remains a Back-end task.
$router->get('/san-pham/page/2', static function (): void {
    $query = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_QUERY);
    header('Location: /san-pham' . ($query ? '?' . $query : ''), true, 301);
});
$router->get('/san-pham/{slug}', [$products, 'show'], ['slug' => $slug]);
$router->get('/danh-muc/{slug}', [$products, 'category'], ['slug' => $categoryPath]);
$router->get('/ve-duvin', [$pages, 'about']);
$router->get('/ve-nha-sang-lap', [$pages, 'founder']);
$router->get('/kien-thuc-whisky', [$pages, 'blog']);
$router->get('/kien-thuc-whisky/page/{page}', static function (string $page) use ($pages): void {
    $pages->blog((int) $page);
}, ['page' => '[1-9][0-9]*']);
$router->get('/blog/{slug}', [$pages, 'article'], ['slug' => $slug]);
$router->get('/tai-khoan/lost-password', [$pages, 'lostPassword']);

// Keep existing bookmarks working while internal links use the current URLs.
$router->get('/ve-dangtau-whisky', static function (): void {
    header('Location: /ve-duvin', true, 301);
});
$router->get('/product-category/{slug}', static function (string $slug): void {
    $query = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_QUERY);
    header('Location: /danh-muc/' . $slug . ($query ? '?' . $query : ''), true, 301);
}, ['slug' => $categoryPath]);

// No application POST endpoints exist yet. Router::post() is available for Phase 2.
