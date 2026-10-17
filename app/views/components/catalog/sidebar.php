<div id="shop-sidebar" class="sidebar-inner col-inner">
    <aside id="text-3" class="widget widget_text"><span class="widget-title shop-sidebar">Lọc sản phẩm</span><div class="is-divider small"></div><div class="textwidget"></div></aside>
    <?php foreach ($filters as $filter): ?>
    <aside id="<?= e($filter['id']) ?>" class="<?= e($filter['class']) ?>">
        <span class="widget-title shop-sidebar"><?= e($filter['title']) ?></span><div class="is-divider small"></div>
        <ul class="woocommerce-widget-layered-nav-list">
            <?php foreach ($filter['options'] as $option): ?>
            <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term">
                <a rel="nofollow" href="<?= e($option['url']) ?>"><?= e($option['label']) ?></a>
                <?php if ($option['count'] !== null): ?><span class="count">(<?= (int) $option['count'] ?>)</span><?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </aside>
    <?php endforeach; ?>
</div>
