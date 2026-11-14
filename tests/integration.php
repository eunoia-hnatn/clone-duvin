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
$articles = new ArticleRepository();
$controller = new ProductController($products, $categories, $catalog, $site);

// 1. Products verification from dynamic database
$all = $products->all();
verify(count($all) === 11, 'Database contains 11 active canonical products');
foreach ($all as $product) {
    verify(is_int($product['price']) && $product['price'] > 0, 'Prices must be numeric VND values');
    verify(is_file(ROOT_PATH . '/public' . $product['image']), 'Catalog image must exist: ' . $product['image']);
    verify($products->findBySlug($product['slug'])['id'] === $product['id'], 'Canonical slug lookup resolves correctly');
}

// 2. Unknown and edge case lookups
verify($products->findBySlug('missing-product') === null, 'Unknown product lookup returns null');
verify($categories->findBySlug('wine/not-a-category') === null, 'Invalid category path returns null');
verify($categories->findBySlug('vang-do') !== null, 'Known wine category returns taxonomy record');
verify($categories->findBySlug('bo-qua-tang') !== null, 'Gift category returns taxonomy record');

// 3. Gift category is driven by real product type
$gifts = $products->forCategory($categories->findBySlug('bo-qua-tang'));
verify(count($gifts) === 3, 'Gift collection contains 3 gifts');
verify(count(array_filter($gifts, static fn (array $p): bool => $p['type'] === 'gift')) === 3, 'All gifts have type = gift');

// 4. Controller show - wine detail
$_SERVER['REQUEST_URI'] = '/san-pham/vang-do-chateau-margaux-grand-cru-2018?gift=1';
$html = capture(static fn () => $controller->show('vang-do-chateau-margaux-grand-cru-2018'));
verify(str_contains($html, 'src="/assets/images/wine1.jpg" class="wp-post-image'), 'Product image rendered from database');
verify(str_contains($html, 'Vang Đỏ Château Margaux Grand Cru'), 'Detail uses the selected product name');

// 5. Controller show - gift detail
$gift = capture(static fn () => $controller->show('set-qua-tang-doanh-nghiep'));
verify(str_contains($gift, 'src="/assets/images/gift1.jpg" class="wp-post-image'), 'Gift image rendered from database');
verify(str_contains($gift, 'Set Quà Tặng Doanh Nghiệp'), 'Gift detail receives database product name');

// 6. 404 error handling
http_response_code(200);
$error = capture(static fn () => $controller->show('missing-product'));
verify(http_response_code() === 404 && str_contains($error, '404 | Duvin'), 'Unknown product returns 404');

http_response_code(200);
capture(static fn () => $controller->category('wine/missing'));
verify(http_response_code() === 404, 'Invalid category parent/child path returns 404');

// 7. Brand and slider counts from database
verify(count($brands->all()) >= 9, 'Brand gallery contains active producer records from database');
$homeContent = $home->content();
verify(count($homeContent['hero_slides']) === 5, 'Hero slider has 5 slides');
verify(count($homeContent['price_slides']) === 4, 'Price slider has 4 slides');

// 8. Dynamic articles verification
verify(count($articles->all()) === 11, 'Articles collection contains 11 records from database');

// 9. Output escaping verification: html output escapes any malicious characters
$rawXss = '<script>alert("xss")</script>';
verify(e($rawXss) === '&lt;script&gt;alert(&quot;xss&quot;)&lt;/script&gt;', 'e() escapes HTML tags and quotation characters');
verify(!str_contains($html, '<script>alert'), 'Detail output does not contain unescaped injected script tags');

// 10. Listing page renders products
$listingHtml = capture(static fn () => $controller->index());
verify(str_contains($listingHtml, 'Vang Đỏ Château Margaux Grand Cru'), 'Listing page renders database products');

// 11. Home and static pages render without any notice or fatal error
$homeController = new HomeController($home, $brands, $site);
$homeHtml = capture(static fn () => $homeController->index());
verify(str_contains($homeHtml, 'Duvin') && strlen($homeHtml) > 1000, 'Home page renders successfully');

$pagesController = new PageController($site, $articles);
$aboutHtml = capture(static fn () => $pagesController->about());
verify(str_contains($aboutHtml, 'Duvin') && strlen($aboutHtml) > 500, 'About page renders');

$founderHtml = capture(static fn () => $pagesController->founder());
verify(str_contains($founderHtml, 'Duvin') && strlen($founderHtml) > 500, 'Founder page renders');

$blogHtml = capture(static fn () => $pagesController->blog());
verify(str_contains($blogHtml, 'Duvin') && strlen($blogHtml) > 500, 'Blog page renders');

$firstArticle = $articles->all()[0];
$articleHtml = capture(static fn () => $pagesController->article($firstArticle['slug']));
verify(str_contains($articleHtml, 'Duvin') && strlen($articleHtml) > 500, 'Article page renders');

$lostPwdHtml = capture(static fn () => $pagesController->lostPassword());
verify(str_contains($lostPwdHtml, 'Duvin') && strlen($lostPwdHtml) > 500, 'Lost password page renders');

echo "PASS: {$count} database integration and MVC checks\n";
