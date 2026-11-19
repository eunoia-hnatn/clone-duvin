<?php

declare(strict_types=1);

final class HomeController extends BaseController
{
    protected ?string $layout = 'layouts/master';

    public function __construct(private HomeRepository $home, private BrandRepository $brands, private SiteRepository $site)
    {
    }

    public function index(): void
    {
        $home = $this->home->content();
        $this->render('home', [
            'pageTitle'    => 'Duvin — Bộ Sưu Tập Rượu Vang Cao Cấp',
            'pageStyles'   => ['/assets/css/home.css'],
            'preloadImage' => $home['hero_slides'][0]['image']['src'] ?? null,
            'home'         => $home,
            'presentation' => $this->home->presentation(),
            'brands'       => $this->brands->all(),
            'site'         => $this->site->content(),
        ]);
    }
}
