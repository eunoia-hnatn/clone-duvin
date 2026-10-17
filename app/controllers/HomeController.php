<?php

declare(strict_types=1);

final class HomeController extends BaseController
{
    public function __construct(private HomeRepository $home, private BrandRepository $brands, private SiteRepository $site)
    {
    }

    public function index(): void
    {
        $this->render('home', [
            'pageTitle' => 'World Class Whisky & Spirit | DangTau Whisky',
            'home' => $this->home->content(),
            'presentation' => $this->home->presentation(),
            'brands' => $this->brands->all(),
            'site' => $this->site->content(),
        ]);
    }
}
