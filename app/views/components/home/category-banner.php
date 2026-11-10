<div class="banner has-hover" id="<?= e($layout['ids'][0]) ?>">
          <div class="banner-inner fill">
        <div class="banner-bg fill" >
            <?php $image = $tab['image']; include __DIR__ . '/../image.php'; ?>
                    </div>

        <div class="banner-layers container">
            <a class="fill" href="<?= e($tab['url']) ?>" ><div class="fill banner-link"></div></a>
   <div id="<?= e($layout['ids'][1]) ?>" class="text-box banner-layer x50 md-x50 lg-x50 y50 md-y50 lg-y50 res-text">
                                <div class="text-box-content text dark">

              <div class="text-inner text-center">

              </div>
           </div>

<style>
#<?= e($layout['ids'][1]) ?> {
  width: 60%;
}
#<?= e($layout['ids'][1]) ?> .text-box-content {
  font-size: 100%;
}
@media (min-width:550px) {
  #<?= e($layout['ids'][1]) ?> {
    width: 60%;
  }
}
</style>
    </div>

        </div>
      </div>


<style>
#<?= e($layout['ids'][0]) ?> {
  padding-top: 45%;
  background-color: <?= e($layout['background']) ?>;
}
#<?= e($layout['ids'][0]) ?> .banner-bg img {
  object-position: 100% 75%;
}
</style>
  </div>
