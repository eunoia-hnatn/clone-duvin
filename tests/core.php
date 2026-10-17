<?php

declare(strict_types=1);

$root = dirname(__DIR__);
define('VIEW_PATH', $root . '/app/views');
require $root . '/app/Core/Router.php';
require $root . '/app/Core/Controller.php';

$count = 0;
function check(bool $condition, string $message): void
{
    global $count;
    if (!$condition) {
        throw new RuntimeException($message);
    }
    $count++;
}
function response(Router $router, string $method, string $uri): array
{
    http_response_code(200);
    ob_start();
    try {
        $router->dispatch($method, $uri);
        return [http_response_code(), ob_get_contents()];
    } finally {
        ob_end_clean();
    }
}

$router = new Router();
$router->get('/items/{slug}', static function (string $slug): void { echo 'get:' . $slug; }, ['slug' => '[a-z0-9-]+']);
$router->post('/items/{slug}', static function (string $slug): void { echo 'post:' . $slug; }, ['slug' => '[a-z0-9-]+']);
$router->get('/category/{path}', static function (string $path): void { echo $path; }, ['path' => '[a-z0-9-]+(?:/[a-z0-9-]+)*']);
$router->get('/literal.v1', static function (): void { echo 'literal'; });
check(response($router, 'GET', '/items/wine-1') === [200, 'get:wine-1'], 'GET route parameter');
check(response($router, 'POST', '/items/wine-1') === [200, 'post:wine-1'], 'POST dispatch on same path');
check(response($router, 'GET', '/items/wine-1/?page=2') === [200, 'get:wine-1'], 'Query and trailing slash normalization');
check(response($router, 'GET', '/category/a/b') === [200, 'a/b'], 'Nested route constraint');
check(response($router, 'GET', '/items/Bad')[0] === 404, 'Invalid parameter must not match');
check(response($router, 'PUT', '/items/wine-1')[0] === 405, 'Known path with unsupported method');
check(response($router, 'POST', '/missing')[0] === 404, 'Unknown path is 404 for POST');
check(response($router, 'GET', '/literalXv1')[0] === 404, 'Static route punctuation must be escaped');
check(response($router, 'GET', '/literal.v1') === [200, 'literal'], 'Literal route');
check(response($router, 'GET', 'http://[')[0] === 404, 'Malformed request target');

$custom = new Router(static function (int $status): void { echo 'error:' . $status; });
check(response($custom, 'GET', '/missing') === [404, 'error:404'], 'Central error handler');

$controller = new BaseController();
ob_start();
$controller->render('errors/http', ['status' => 405, '__template' => '/does/not/exist']);
$html = ob_get_clean();
check(str_contains($html, '405 | Duvin'), 'Render receives explicit data and protects template path');
foreach (['../controllers/HomeController', 'missing', '../../index'] as $view) {
    try {
        $controller->render($view);
        throw new RuntimeException('Expected render rejection');
    } catch (InvalidArgumentException $e) {
        check(true, 'Reject missing or out-of-directory view');
    }
}
echo "PASS: {$count} core checks\n";
