<div class="gallery-col col" data-animate="fadeInLeft">
    <div class="col-inner">
        <div class="box has-hover gallery-box box-none">
            <div class="box-image brand-box-image">
                <?php $image = array_replace($presentation['brand_image_defaults'] ?? [], $brand['image'] ?? []); include __DIR__ . '/../image.php'; ?>
                <div class="overlay fill brand-overlay-clear"></div>
            </div>
            <div class="box-text text-left">
                <p><?= e($brand['url']) ?></p>
            </div>
        </div>
    </div>
</div>
