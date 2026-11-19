<?php

declare(strict_types=1);

final class ProductController extends BaseController
{
    protected ?string $layout = 'layouts/master';

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
            'pageTitle'          => $category['title'] . ' | Duvin',
            'pageStyles'         => ['/assets/css/products.css'],
            'category'           => $category,
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
        $relatedProducts = (new RecommendationService())->forProduct($product, $this->products, 8);
        $this->render('product-detail', [
            'pageTitle'       => $product['name'] . ' | Duvin',
            'pageStyles'      => ['/assets/css/pdp.css'],
            'body_class'      => 'single-product woocommerce woocommerce-page',
            'product'         => $product,
            'vintages'        => $this->products->vintagesForProduct($product),
            'reviews'         => $this->products->reviewsForProduct($product),
            'faqs'            => $this->products->faqs(),
            'commitments'     => $this->products->commitments(),
            'detail'          => $this->catalog->detail(),
            'relatedProducts' => $relatedProducts,
            'priceNote'       => $this->catalog->priceNote(),
            'site'            => $this->site->content(),
        ]);
    }
}
