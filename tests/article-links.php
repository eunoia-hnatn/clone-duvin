<?php

declare(strict_types=1);

$router = require dirname(__DIR__) . '/bootstrap/app.php';
require ROOT_PATH . '/routes/web.php';

$count = 0;
function verifyLink(bool $condition, string $message): void
{
    global $count;
    if (!$condition) {
        throw new RuntimeException($message);
    }
    $count++;
}
function pageResponse(Router $router, string $url): array
{
    $_SERVER['REQUEST_URI'] = $url;
    ob_start();
    try {
        $router->dispatch('GET', $url);
        return [http_response_code(), ob_get_contents()];
    } finally {
        ob_end_clean();
    }
}

$repository = new ArticleRepository();
$all = $repository->all();
$seen = [];
$pageCount = $repository->paginate(1)['pages'];
for ($page = 1; $page <= $pageCount; $page++) {
    $result = $repository->paginate($page);
    verifyLink(count($result['items']) <= 3, 'Article pages must respect page size');
    verifyLink($result['total'] === count($all), 'Total must describe the full collection');
    foreach ($result['items'] as $article) {
        $seen[] = $article['url'];
    }
    $url = $page === 1 ? '/kien-thuc-whisky' : '/kien-thuc-whisky/page/' . $page;
    [$status, $html] = pageResponse($router, $url);
    verifyLink($status === 200 && str_contains($html, 'aria-current="page"'), 'Article pagination route and current-page marker');
}
verifyLink($seen === array_column($all, 'url'), 'Pagination must preserve article order without skipping or repeating records');
foreach ($all as $article) {
    $slug = basename(rtrim($article['url'], '/'));
    verifyLink($repository->findBySlug($slug) === $article, 'Existing article lookup');
    [$status, $html] = pageResponse($router, $article['url']);
    verifyLink($status === 200 && str_contains($html, '<h1>' . e($article['title']) . '</h1>'), 'Detail routes use the matching article data');
    verifyLink(substr_count($html, 'src="/assets/js/index.js"') === 1, 'Global index.js must be enqueued once');
}
verifyLink($repository->findBySlug('not-a-real-article') === null, 'Unknown article lookup');
verifyLink(pageResponse($router, '/blog/not-a-real-article')[0] === 404, 'Unknown article route remains 404');
verifyLink(pageResponse($router, '/kien-thuc-whisky/page/' . ($pageCount + 1))[0] === 404, 'Out-of-range article pages remain 404');
verifyLink(pageResponse($router, '/tai-khoan/lost-password')[0] === 200, 'Password help link has a real destination');
try {
    $repository->paginate(0);
    throw new RuntimeException('Expected invalid pagination rejection');
} catch (InvalidArgumentException $e) {
    verifyLink(true, 'Invalid pagination input is rejected');
}
echo "PASS: {$count} article/link regression checks\n";
