<?php
// Isolate recursive partial variables from the caller and sibling menus.
(static function (array $items): void {
    foreach ($items as $item):
        $attrs = $item['attributes'] ?? [];
        $linkAttrs = $item['link_attributes'] ?? [];
        $iconAttrs = $item['icon_attributes'] ?? null;
        $iconBefore = $item['icon_before'] ?? true;
        $labelWrapper = $item['label_wrapper'] ?? null;
        $children = $item['children'] ?? [];
        $childrenAttrs = $item['children_attributes'] ?? [];
?>
<li <?= htmlAttributes($attrs) ?>>
    <a <?= htmlAttributes($linkAttrs) ?>><?php if ($iconAttrs !== null && $iconBefore): ?><i <?= htmlAttributes($iconAttrs) ?>></i><?php endif; ?><?php if ($labelWrapper === 'span'): ?><span><?php endif; ?><?= e($item['label'] ?? '') ?><?php if ($labelWrapper === 'span'): ?></span><?php endif; ?><?php if ($iconAttrs !== null && !$iconBefore): ?><i <?= htmlAttributes($iconAttrs) ?>></i><?php endif; ?></a>
    <?php if ($children !== []): ?>
    <ul <?= htmlAttributes($childrenAttrs) ?>><?php $menuItems = $children; include __FILE__; ?></ul>
    <?php endif; ?>
</li>
<?php endforeach;
})($menuItems);
