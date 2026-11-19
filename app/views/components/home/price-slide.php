<div class="banner has-hover price-slide-banner" id="<?= e($layout['ids'][0]) ?>">
    <div class="banner-inner fill">
        <div class="banner-bg fill">
            <?php $image = $slide['image']; include __DIR__ . '/../image.php'; ?>
        </div>
        <div class="banner-layers container">
            <?php if ($slide['banner_url'] !== null): ?><a class="fill" href="<?= e($slide['banner_url']) ?>"><div class="fill banner-link"></div></a><?php else: ?><div class="fill banner-link"></div><?php endif; ?>
            <div id="<?= e($layout['ids'][1]) ?>" class="text-box banner-layer slider-whisky-pricerange-title x5 md-x5 lg-x5 y10 md-y10 lg-y10 res-text">
                <div class="text-box-content text dark">
                    <div class="text-inner text-left">
                        <div id="<?= e($layout['ids'][2]) ?>" class="text dtile">
                            <h2><?php foreach ($slide['title_lines'] as $lineIndex => $line): ?><?= $lineIndex === 0 ? '' : '<br class="br-mobile">' ?><?= e($line) ?><?php endforeach; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div id="<?= e($layout['ids'][3]) ?>" class="text-box banner-layer slider-whisky-pricerange-btn x5 md-x5 lg-x5 y95 md-y95 lg-y95 res-text">
                <div class="text-box-content text dark">
                    <div class="text-inner text-left">
                        <a href="<?= e($slide['button_url']) ?>" class="button white is-outline">
                            <span><?= e($slide['button_label']) ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
