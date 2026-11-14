<?php
/** @var Router $router */

/* =========================================================
 * Age Gate — routes KHÔNG bị middleware chặn
 * Phải đăng ký TRƯỚC group để không bị AgeGateMiddleware intercept
 * ========================================================= */
$ageGate = new AgeGateController();
$router->get('/age-verify',  [$ageGate, 'showVerify']);
$router->post('/age-verify', [$ageGate, 'handleVerify']);
$router->get('/under-18',    [$ageGate, 'showUnder18']);

/* =========================================================
 * Routes được bảo vệ bởi AgeGateMiddleware
 * Mọi request vào đây đều qua kiểm tra cookie age_verified
 * ========================================================= */
$home     = new HomeController(new HomeRepository(), new BrandRepository(), new SiteRepository());
$products = new ProductController(new ProductRepository(), new CategoryRepository(), new CatalogRepository(), new SiteRepository());
$pages    = new PageController(new SiteRepository(), new ArticleRepository());
$slug         = '[a-z0-9-]+';
$categoryPath = '[a-z0-9-]+(?:/[a-z0-9-]+)*';

$router->group('/', function (Router $router) use ($home, $products, $pages, $slug, $categoryPath): void {

    $router->get('/',     [$home, 'index']);
    $router->get('/home', [$home, 'index']);

    $router->get('/san-pham', [$products, 'index']);
    $router->get('/san-pham/page/2', static function (): void {
        $query = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_QUERY);
        header('Location: /san-pham' . ($query ? '?' . $query : ''), true, 301);
    });
    $router->get('/san-pham/{slug}',  [$products, 'show'],     ['slug' => $slug]);
    $router->get('/danh-muc/{slug}',  [$products, 'category'], ['slug' => $categoryPath]);

    $router->get('/ve-duvin',         [$pages, 'about']);
    $router->get('/ve-nha-sang-lap',  [$pages, 'founder']);
    $router->get('/kien-thuc-whisky', [$pages, 'blog']);
    $router->get('/kien-thuc-whisky/page/{page}', static function (string $page) use ($pages): void {
        $pages->blog((int) $page);
    }, ['page' => '[1-9][0-9]*']);
    $router->get('/blog/{slug}',           [$pages, 'article'],      ['slug' => $slug]);
    $router->get('/tai-khoan/lost-password', [$pages, 'lostPassword']);

    // Legacy redirects
    $router->get('/ve-dangtau-whisky', static function (): void {
        header('Location: /ve-duvin', true, 301);
    });
    $router->get('/product-category/{slug}', static function (string $slug): void {
        $query = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_QUERY);
        header('Location: /danh-muc/' . $slug . ($query ? '?' . $query : ''), true, 301);
    }, ['slug' => $categoryPath]);

}, [AgeGateMiddleware::class]);
