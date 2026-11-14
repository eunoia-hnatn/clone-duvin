<div class="banner has-hover category-tab-banner" id="<?= e($layout['ids'][0]) ?>">
    <div class="banner-inner fill">
        <div class="banner-bg fill">
            <?php $image = $tab['image']; include __DIR__ . '/../image.php'; ?>
        </div>
        <div class="banner-layers container">
            <a class="fill" href="<?= e($tab['url']) ?>"><div class="fill banner-link"></div></a>
            <div id="<?= e($layout['ids'][1]) ?>" class="text-box banner-layer category-tab-textbox x50 md-x50 lg-x50 y50 md-y50 lg-y50 res-text">
                <div class="text-box-content text dark">
                    <div class="text-inner text-center"></div>
                </div>
            </div>
        </div>
    </div>
</div>
