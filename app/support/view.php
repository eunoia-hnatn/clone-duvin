<?php
function e(string $value): string { return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function sitemap(): array {
    static $map;
    return $map ??= require APP_PATH . '/config/sitemap.php';
}
function categoryIndex(): array {
    $result = [];
    foreach (sitemap()['products'] as $item) {
        $result[substr($item['url'], strlen('/danh-muc/'))] = $item;
        foreach ($item['children'] ?? [] as $child) {
            $result[substr($child['url'], strlen('/danh-muc/'))] = $child;
        }
    }
    return $result;
}
function renderMenu(array $items, string $mode = 'desktop'): void {
    foreach ($items as $item) {
        $children = $item['children'] ?? [];
        echo '<li class="menu-item' . ($children ? ' menu-item-has-children' : '') . '">';
        if ($children) echo '<details class="menu-group"><summary>' . e($item['label']) . '</summary><ul class="menu-children"><li><a href="' . e($item['url']) . '">Xem tất cả ' . e($item['label']) . '</a></li>';
        else echo '<a href="' . e($item['url']) . '">' . e($item['label']) . '</a>';
        if ($children) { renderMenu($children, $mode); echo '</ul></details>'; }
        echo '</li>';
    }
}
function notFound(): void {
    http_response_code(404);
    $pageTitle = '404 — Trang không tồn tại | DangTau Whisky';
    require VIEW_PATH . '/404.php';
}
