<?php
/** Front controller. Document root remains the repository root. */
define('ROOT_PATH', __DIR__);
define('APP_PATH', ROOT_PATH . '/app');
define('VIEW_PATH', APP_PATH . '/views');
require APP_PATH . '/support/view.php';
$uri = rtrim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/', '/') ?: '/';

// Explicit legacy aliases only. Removed content deliberately has no redirect.
$aliases = ['/index.html'=>'/', '/products.html'=>'/san-pham', '/wine'=>'/danh-muc/wine', '/product/the-lakes-gift-set'=>'/danh-muc/bo-qua-tang'];
foreach (categoryIndex() as $slug => $item) $aliases['/product-category/' . $slug] = $item['url'];
foreach (['cognac','gin','rum','calvados','ruou-trung-quoc'] as $slug) {
    $aliases['/danh-muc/' . $slug] = '/danh-muc/world-whisky/' . $slug;
    $aliases['/product-category/' . $slug] = '/danh-muc/world-whisky/' . $slug;
}
foreach (['/danh-muc/', '/product-category/'] as $prefix) $aliases[$prefix . 'world-whisky/whisky-khac'] = '/danh-muc/world-whisky/bourbon-whiskey';
foreach (sitemap()['blogs'] as $item) $aliases['/danh-muc/' . basename($item['url'])] = $item['url'];
if (isset($aliases[$uri])) {
    $query = $_SERVER['QUERY_STRING'] ?? '';
    header('Location: ' . $aliases[$uri] . ($query ? '?' . $query : ''), true, 302);
    exit;
}
$routes = [
    ['#^/(?:home)?$#', 'HomeController', 'index'],
    ['#^/san-pham$#', 'ProductController', 'index'],
    ['#^/san-pham/([a-z0-9-]+)$#', 'ProductController', 'show'],
    ['#^/danh-muc/([a-z0-9/-]+)$#', 'ProductController', 'category'],
    ['#^/ve-dangtau-whisky$#', 'PageController', 'about'],
    ['#^/ve-nha-sang-lap$#', 'PageController', 'founder'],
    ['#^/kien-thuc-whisky$#', 'PageController', 'blog'],
    ['#^/kien-thuc-whisky/([a-z0-9-]+)$#', 'PageController', 'blog'],
    ['#^/dich-vu-ca-nhan-hoa$#', 'PageController', 'services'],
    ['#^/search$#', 'PageController', 'search'],
];
foreach ($routes as [$pattern, $class, $method]) {
    if (preg_match($pattern, $uri, $matches)) {
        require APP_PATH . '/controllers/' . $class . '.php';
        $controller = new $class();
        isset($matches[1]) ? $controller->$method($matches[1]) : $controller->$method();
        exit;
    }
}
notFound();
