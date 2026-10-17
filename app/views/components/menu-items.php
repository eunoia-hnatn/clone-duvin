<?php
// Isolate recursive partial variables from the caller and sibling menus.
(static function (array $items): void {
    foreach ($items as $item): ?>
<li <?= htmlAttributes($item['attributes']) ?>>
    <a <?= htmlAttributes($item['link_attributes']) ?>><?php if ($item['icon_attributes'] !== null && $item['icon_before']): ?><i <?= htmlAttributes($item['icon_attributes']) ?>></i><?php endif; ?><?php if ($item['label_wrapper'] === 'span'): ?><span><?php endif; ?><?= e($item['label']) ?><?php if ($item['label_wrapper'] === 'span'): ?></span><?php endif; ?><?php if ($item['icon_attributes'] !== null && !$item['icon_before']): ?><i <?= htmlAttributes($item['icon_attributes']) ?>></i><?php endif; ?></a>
    <?php if ($item['children'] !== []): ?>
    <ul <?= htmlAttributes($item['children_attributes']) ?>><?php $menuItems = $item['children']; include __FILE__; ?></ul>
    <?php endif; ?>
</li>
<?php endforeach;
})($menuItems);
