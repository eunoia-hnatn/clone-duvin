<?php
/**
 * PageController
 * Xử lý các trang tĩnh/nội dung của DuVin
 */
class PageController extends BaseController
{
    public function __construct(private SiteRepository $site, private ArticleRepository $articles)
    {
    }

    /**
     * Về DuVin — GET /ve-duvin
     */
    public function about(): void
    {
        $pageTitle = 'Về DuVin | DuVin';
        $this->render('about', ['pageTitle' => $pageTitle, 'site' => $this->site->content()]);
    }

    /**
     * Về nhà sáng lập — GET /ve-nha-sang-lap
     */
    public function founder(): void
    {
        $pageTitle = 'Về Nhà Sáng Lập | DuVin';
        $this->render('founder', ['pageTitle' => $pageTitle, 'site' => $this->site->content()]);
    }

    /**
     * Kiến thức Whisky — GET /kien-thuc-whisky
     */
    public function blog(int $page = 1): void
    {
        $pagination = $this->articles->paginate($page);
        if ($page > $pagination['pages']) {
            $this->notFound();
            return;
        }
        $this->render('blog', [
            'pageTitle' => 'Wine Knowledge | Duvin',
            'site' => $this->site->content(),
            'articles' => $pagination['items'],
            'articleCategories' => $this->articles->categories(),
            'pagination' => $pagination,
        ]);
    }

    public function article(string $slug): void
    {
        $article = $this->articles->findBySlug($slug);
        if ($article === null) {
            $this->notFound();
            return;
        }
        $this->render('article', [
            'pageTitle' => $article['title'] . ' | Duvin',
            'article' => $article,
            'site' => $this->site->content(),
        ]);
    }

    public function lostPassword(): void
    {
        $this->render('lost-password', [
            'pageTitle' => 'Khôi phục mật khẩu | Duvin',
            'site' => $this->site->content(),
        ]);
    }

    private function notFound(): void
    {
        http_response_code(404);
        $this->render('errors/http', ['status' => 404]);
    }

}
