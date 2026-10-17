<?php

declare(strict_types=1);

class BaseController
{
    public function render(string $view, array $data = []): void
    {
        $base = realpath(VIEW_PATH);
        $file = realpath(VIEW_PATH . '/' . $view . '.php');
        if ($base === false || $file === false || !is_file($file)
            || !str_starts_with($file, $base . DIRECTORY_SEPARATOR)) {
            throw new InvalidArgumentException('View not found: ' . $view);
        }

        // The isolated scope prevents data keys from replacing the template path.
        (static function (string $__template, array $__data): void {
            extract($__data, EXTR_SKIP);
            require $__template;
        })($file, $data);
    }
}
