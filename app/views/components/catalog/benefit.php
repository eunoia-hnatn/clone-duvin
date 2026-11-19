<div id="<?= e($benefit['id']) ?>" class="col medium-12 small-12 large-6 featured-box-col">
    <div class="col-inner">
        <div class="icon-box featured-box icon-box-left text-left">
            <div class="icon-box-img">
                <div class="icon">
                    <div class="icon-inner">
                        <?php $image = $benefit['image']; include __DIR__ . '/../image.php'; ?>
                    </div>
                </div>
            </div>
            <div class="icon-box-text last-reset"><p><?= e($benefit['text']) ?></p></div>
        </div>
    </div>
</div>
