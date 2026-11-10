<?php

declare(strict_types=1);

final class ProductController extends BaseController
{
    public function __construct(
        private ProductRepository $products,
        private CategoryRepository $categories,
        private CatalogRepository $catalog,
        private SiteRepository $site
    ) {
    }

    public function index(): void
    {
        $this->listing($this->categories->overview());
    }

    public function category(string $slug): void
    {
        $category = $this->categories->findBySlug($slug);
        if ($category === null) {
            $this->notFound();
            return;
        }
        $this->listing($category);
    }

    private function listing(array $category): void
    {
        $this->render('products', [
            'pageTitle' => $category['title'] . ' | Duvin',
            'category' => $category,
            'isGiftCategory' => $category['slug'] === 'bo-qua-tang',
            'products' => $this->products->forCategory($category),
            'categoryNavigation' => $this->categories->navigation(),
            'filters' => $this->catalog->filters(),
            'priceNote' => $this->catalog->priceNote(),
            'site' => $this->site->content(),
        ]);
    }

    public function show(string $slug): void
    {
        $product = $this->products->findBySlug($slug);
        if ($product === null) {
            $this->notFound();
            return;
        }
        $relatedProducts = array_values(array_filter(
            $this->products->findMany($this->catalog->relatedSlugs()),
            static fn (array $candidate): bool => $candidate['slug'] !== $product['slug']
        ));
        $this->render('product-detail', [
            'pageTitle' => $product['name'] . ' | Duvin',
            'body_class' => 'single-product woocommerce woocommerce-page',
            'product' => $product,
            'detail' => $this->catalog->detail(),
            'relatedProducts' => $relatedProducts,
            'priceNote' => $this->catalog->priceNote(),
            'site' => $this->site->content(),
        ]);
    }

    private function notFound(): void
    {
        http_response_code(404);
        $this->render('errors/http', ['status' => 404]);
    }
}
