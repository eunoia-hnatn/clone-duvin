<?php

declare(strict_types=1);

class BaseController
{
    protected ?string $layout = null;

    public function render(string $view, array $data = [], ?string $layout = null): void
    {
        $viewFile = $this->resolveViewFile($view);
        $activeLayout = func_num_args() >= 3 ? $layout : $this->layout;

        if ($activeLayout === null) {
            $this->renderTemplate($viewFile, $data);
            return;
        }

        $layoutFile = $this->resolveViewFile($activeLayout);

        // Render view content into buffer
        ob_start();
        $this->renderTemplate($viewFile, $data);
        $content = ob_get_clean();

        // Render layout with injected content
        $defaults = [
            'pageTitle' => 'Duvin - Fine Wine Collection',
            'metaDescription' => 'Duvin - Bộ sưu tập rượu vang cao cấp từ khắp thế giới.',
        ];
        if (class_exists('SiteRepository')) {
            try {
                $siteRepo = new SiteRepository();
                $defaults['site'] = $siteRepo->content();
                $defaults['settings'] = $siteRepo->getSettings();
            } catch (Throwable) {
                // Ignore if repository dependencies not ready
            }
        }
        $layoutData = array_merge($defaults, $data, ['content' => $content]);
        $this->renderTemplate($layoutFile, $layoutData);
    }

    public function view(string $view, array $data = [], ?string $layout = null): void
    {
        $this->render($view, $data, $layout);
    }

    public function json(mixed $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function redirect(string $url, int $status = 302): void
    {
        http_response_code($status);
        header('Location: ' . $url, true, $status);
    }

    public function notFound(string $message = 'Trang không tồn tại'): void
    {
        http_response_code(404);
        $this->render('errors/http', [
            'status' => 404,
            'message' => $message,
            'pageTitle' => '404 | Duvin',
        ], null);
    }

    private function resolveViewFile(string $view): string
    {
        $base = realpath(defined('VIEW_PATH') ? VIEW_PATH : dirname(__DIR__) . '/views');
        $viewPath = (defined('VIEW_PATH') ? VIEW_PATH : dirname(__DIR__) . '/views') . '/' . $view . '.php';
        $file = realpath($viewPath);

        if ($base === false || $file === false || !is_file($file)
            || !str_starts_with($file, $base . DIRECTORY_SEPARATOR)) {
            throw new InvalidArgumentException('View not found: ' . $view);
        }

        return $file;
    }

    private function renderTemplate(string $__file, array $__data): void
    {
        // The isolated scope prevents data keys from replacing the template path.
        (static function (string $__template, array $__data): void {
            extract($__data, EXTR_SKIP);
            require $__template;
        })($__file, $__data);
    }
}
