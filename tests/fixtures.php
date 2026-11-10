<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap/app.php';
$count = 0;
function verify(bool $condition, string $message): void
{
    global $count;
    if (!$condition) {
        throw new RuntimeException($message);
    }
    $count++;
}
function capture(callable $action): string
{
    ob_start();
    try {
        $action();
        return ob_get_contents();
    } finally {
        ob_end_clean();
    }
}

$products = new ProductRepository();
$categories = new CategoryRepository();
$catalog = new CatalogRepository();
$site = new SiteRepository();
$home = new HomeRepository();
$brands = new BrandRepository();
$controller = new ProductController($products, $categories, $catalog, $site);
$all = $products->all();
verify(count($all) === 11, 'Duplicate catalog entries must share one canonical record');
foreach ($all as $product) {
    verify(is_int($product['price']) && $product['price'] > 0, 'Prices must be numeric VND values');
    verify(is_file(ROOT_PATH . '/public' . $product['image']), 'Catalog image must exist');
    verify($products->findBySlug($product['slug']) === $product, 'Canonical lookup');
    foreach ($product['aliases'] as $alias) {
        verify($products->findBySlug($alias) === $product, 'Legacy links resolve to their actual product');
    }
}
verify($products->findBySlug('missing-product') === null, 'Unknown product is not a fabricated demo');
verify($categories->findBySlug('wine/not-a-category') === null, 'Validate complete category path');
verify($categories->findBySlug('scotch-whisky/whisky-islay') !== null, 'Known nested category remains available');
foreach ($categories->all() as $category) {
    verify(count($products->forCategory($category)) > 0, 'Every category collection references actual fixtures');
}
$gifts = $products->forCategory($categories->findBySlug('bo-qua-tang'));
verify(count($gifts) === 3 && count(array_filter($gifts, static fn (array $p): bool => $p['type'] === 'gift')) === 3, 'Gift category is driven by product type data');

$_SERVER['REQUEST_URI'] = '/san-pham/vang-do-chateau-margaux-grand-cru-2018?gift=1';
$html = capture(static fn () => $controller->show('vang-do-chateau-margaux-grand-cru-2018'));
verify(str_contains($html, 'src="/assets/images/wine1.jpg" class="wp-post-image'), 'Query strings cannot select the gift template');
verify(str_contains($html, 'Vang Đỏ Château Margaux Grand Cru 2018'), 'Detail uses the selected product');
$gift = capture(static fn () => $controller->show('set-qua-tang-doanh-nghiep'));
verify(str_contains($gift, 'src="/assets/images/gift1.jpg" class="wp-post-image'), 'Gift image comes from that product, not a fixed template');
verify(str_contains($gift, 'Set Quà Tặng Doanh Nghiệp'), 'Gift detail receives real fixture name');
http_response_code(200);
$error = capture(static fn () => $controller->show('missing-product'));
verify(http_response_code() === 404 && str_contains($error, '404 | Duvin'), 'Unknown product returns 404');
http_response_code(200);
capture(static fn () => $controller->category('wine/missing'));
verify(http_response_code() === 404, 'Invalid category parent/child path returns 404');
verify(count($brands->all()) === 16, 'Brand gallery data');
verify(count($home->content()['hero_slides']) === 5 && count($home->content()['price_slides']) === 4, 'Both home sliders retain their slide counts');
verify(count((new ArticleRepository())->all()) === 11, 'Article cards are extracted, including repaired legacy card');

// Prove Views depend on Repository data and escape it; never modify real fixtures.
$temporary = sys_get_temp_dir() . '/duvin-fixtures-' . bin2hex(random_bytes(6));
mkdir($temporary);
register_shutdown_function(static function () use ($temporary): void {
    foreach (glob($temporary . '/*') as $file) {
        unlink($file);
    }
    rmdir($temporary);
});
$override = require ROOT_PATH . '/database/fixtures/products.php';
$slug = 'vang-do-chateau-margaux-grand-cru-2018';
$override[$slug]['name'] = '<script>alert("fixture")</script>';
$override[$slug]['price'] = 1234567;
file_put_contents($temporary . '/products.php', '<?php return ' . var_export($override, true) . ';');
$injected = new ProductController(new ProductRepository($temporary), $categories, $catalog, $site);
$html = capture(static fn () => $injected->show($slug));
verify(str_contains($html, '1.234.567'), 'Editing fixture data updates rendered price');
verify(str_contains($html, '&lt;script&gt;') && !str_contains($html, '<script>alert("fixture")</script>'), 'Product names are escaped at output');
$listing = capture(static fn () => $injected->index());
verify(str_contains($listing, '1.234.567') && str_contains($listing, '&lt;script&gt;'), 'Listing and detail share the same data source');

try {
    $products->findMany(['missing-reference']);
    throw new RuntimeException('Expected broken fixture reference rejection');
} catch (UnexpectedValueException $e) {
    verify(true, 'Broken fixture references fail explicitly');
}
echo "PASS: {$count} fixture and MVC integration checks\n";
