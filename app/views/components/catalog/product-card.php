<div class="product-small col has-hover product type-product <?= $cardProduct['in_stock'] ? 'instock' : 'out-of-stock outofstock' ?> has-post-thumbnail shipping-taxable product-type-simple">
    <div class="col-inner">
        <div class="badge-container absolute left top z-1"></div>
        <div class="product-small box">
            <div class="box-image">
                <div class="image-zoom">
                    <a href="/san-pham/<?= e($cardProduct['slug']) ?>/" aria-label="<?= e($cardProduct['name']) ?>">
                        <img width="1920" height="1920" src="<?= e($cardProduct['image']) ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="<?= e($cardProduct['name']) ?>" decoding="async" <?= $index === 0 ? '' : 'loading="lazy"' ?>>
                    </a>
                </div>
                <div class="image-tools is-small top right show-on-hover"></div>
                <div class="image-tools engraving-badge"></div>
                <div class="image-tools is-small hide-for-small bottom left show-on-hover"></div>
                <div class="image-tools grid-tools text-center hide-for-small bottom hover-slide-in show-on-hover"></div>
                <?php if (!$cardProduct['in_stock']): ?><div class="out-of-stock-label">Liên hệ</div><?php endif; ?>
            </div>
            <div class="box-text box-text-products">
                <div class="title-wrapper">
                    <p class="category uppercase is-smaller no-text-overflow product-cat op-7"><?= e($cardProduct['category_label']) ?></p>
                    <p class="name product-title woocommerce-loop-product__title"><a href="/san-pham/<?= e($cardProduct['slug']) ?>/" class="woocommerce-LoopProduct-link woocommerce-loop-product__link"><?= e($cardProduct['name']) ?></a></p>
                </div>
                <div class="price-wrapper">
                    <span class="price"><span class="woocommerce-Price-amount amount"><bdi><?= e(money($cardProduct['price'])) ?><span class="woocommerce-Price-currencySymbol">&#8363;</span></bdi></span></span>
                    <div class="price-note" style="font-size:12px;color:#777;margin-top:4px;"><?= e($priceNote) ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
