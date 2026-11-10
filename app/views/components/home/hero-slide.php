<div class="<?= e($layout['row_class']) ?>"  id="<?= e($layout['ids'][0]) ?>">

	<div <?= htmlAttributes($layout['column_attributes']) ?>>
				<div <?= htmlAttributes($layout['inner_attributes']) ?>>


<div class="row row-collapse"  id="<?= e($layout['ids'][2]) ?>">

	<div id="<?= e($layout['ids'][3]) ?>" class="col center-maxwidth-50 small-12 large-12"  data-animate="fadeInLeft">
				<div class="col-inner"  >


	<div id="<?= e($layout['ids'][4]) ?>" class="text dtsubtitle">

<p><?= e($slide['subtitle']) ?></p>
			</div>

	<div id="<?= e($layout['ids'][5]) ?>" class="text dtile">

<h2><?php foreach ($slide['title_lines'] as $lineIndex => $line): ?><?= $lineIndex === 0 ? '' : '<br class="br-mobile">' ?><?= e($line) ?><?php endforeach; ?></h2>

<style>
#<?= e($layout['ids'][5]) ?> {
  font-size: 1.65rem;
}
<?php if ($layout['light_heading']): ?>
#<?= e($layout['ids'][5]) ?>, #<?= e($layout['ids'][5]) ?> > * { color: #fcf7e8; }
<?php endif; ?>
</style>
	</div>

<p><?= e($slide['description']) ?></p>
<a href="<?= e($slide['button_url']) ?>" <?= htmlAttributes($layout['link_attributes'][0]) ?>>
		<span><?= e($slide['button_label']) ?></span>
	</a>

		</div>
					</div>


</div>
		</div>
					</div>



	<div id="<?= e($layout['ids'][6]) ?>" class="col medium-6 small-12 large-6"  >
				<div class="col-inner"  >



  <div class="banner has-hover" id="<?= e($layout['ids'][7]) ?>">
          <div class="banner-inner fill">
        <div class="banner-bg fill" >
            <?php $image = $slide['image']; include __DIR__ . '/../image.php'; ?>
                    </div>

        <div class="banner-layers container">
            <a href="<?= e($slide['banner_url']) ?>" <?= htmlAttributes($layout['link_attributes'][1]) ?>><div class="fill banner-link"></div></a>
   <div id="<?= e($layout['ids'][8]) ?>" class="text-box banner-layer x50 md-x50 lg-x50 y50 md-y50 lg-y50 res-text">
                                <div class="text-box-content text dark">

              <div class="text-inner text-center">

              </div>
           </div>

<style>
#<?= e($layout['ids'][8]) ?> {
  width: 60%;
}
#<?= e($layout['ids'][8]) ?> .text-box-content {
  font-size: 100%;
}
@media (min-width:550px) {
  #<?= e($layout['ids'][8]) ?> {
    width: 60%;
  }
}
</style>
    </div>

        </div>
      </div>


<style>
#<?= e($layout['ids'][7]) ?> {
  padding-top: <?= e($layout['height']) ?>;
}
#<?= e($layout['ids'][7]) ?> .banner-bg img {
  object-position: <?= e($layout['position']) ?>;
}
</style>
  </div>


		</div>
					</div>


</div>
