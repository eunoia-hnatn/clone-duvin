<?php

declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('VIEW_PATH', APP_PATH . '/views');

require_once APP_PATH . '/Core/Router.php';
require_once APP_PATH . '/Core/Controller.php';
require_once APP_PATH . '/Core/helpers.php';
require_once APP_PATH . '/Repositories/FixtureRepository.php';
foreach (['ProductRepository', 'CategoryRepository', 'BrandRepository', 'HomeRepository', 'CatalogRepository', 'SiteRepository', 'ArticleRepository'] as $repository) {
    require_once APP_PATH . '/Repositories/' . $repository . '.php';
}
require_once APP_PATH . '/controllers/HomeController.php';
require_once APP_PATH . '/controllers/PageController.php';
require_once APP_PATH . '/controllers/ProductController.php';

return new Router(static function (int $status): void {
    (new BaseController())->render('errors/http', ['status' => $status]);
});
