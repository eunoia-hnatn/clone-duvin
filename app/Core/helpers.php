<?php

declare(strict_types=1);

/** Escape dynamic database values at the HTML output boundary. */
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function money(int $amount): string
{
    return number_format($amount, 0, ',', '.');
}


/** Format HTML attribute arrays safely. */
function htmlAttributes(array $attributes): string
{
    $html = [];
    foreach ($attributes as $name => $value) {
        if (!preg_match('/^[a-zA-Z_:][a-zA-Z0-9_:.-]*$/D', (string) $name)) {
            throw new InvalidArgumentException('Invalid HTML attribute name.');
        }
        $html[] = $value === null ? e($name) : e($name) . '="' . e($value) . '"';
    }
    return implode(' ', $html);
}

/** Append ?v=<filemtime> cache-busting query string for local public assets. */
function asset(string $path): string
{
    $clean = '/' . ltrim($path, '/');
    $basePath = defined('ROOT_PATH') ? ROOT_PATH . '/public' : dirname(__DIR__, 2) . '/public';
    $fileOnly = strtok($clean, '?');
    $fullPath = $basePath . ($fileOnly !== false ? $fileOnly : $clean);
    if (is_file($fullPath)) {
        $mtime = filemtime($fullPath);
        if ($mtime !== false) {
            $sep = str_contains($clean, '?') ? '&' : '?';
            return $clean . $sep . 'v=' . $mtime;
        }
    }
    return $clean;
}
