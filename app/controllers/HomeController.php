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
        $this->render('home', [
            'pageTitle' => 'Duvin — Bộ Sưu Tập Rượu Vang Cao Cấp',
            'home' => $this->home->content(),
            'presentation' => $this->home->presentation(),
            'brands' => $this->brands->all(),
            'site' => $this->site->content(),
        ]);
    }
}
