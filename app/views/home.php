
	<main id="main" class="">

<div id="content" role="main" class="content-area">

	<section class="section" id="section_1194579430">
		<div class="section-bg fill" >

		</div>

		<div class="section-content relative">

<div class="slider-wrapper relative home-mainslider" id="slider-1466808294" >
    <div class="slider slider-type-fade slider-nav-circle slider-nav-large slider-nav-light slider-style-normal slider-show-nav"
        data-flickity-options='{
            "cellAlign": "center",
            "imagesLoaded": true,
            "lazyLoad": 1,
            "freeScroll": false,
            "wrapAround": true,
            "autoPlay": 3000,
            "pauseAutoPlayOnHover" : true,
            "prevNextButtons": false,
            "contain" : true,
            "adaptiveHeight" : true,
            "dragThreshold" : 10,
            "percentPosition": true,
            "pageDots": true,
            "rightToLeft": false,
            "draggable": false,
            "selectedAttraction": 0.1,
            "parallax" : 0,
            "friction": 0.6        }'
        >

<?php foreach ($home['hero_slides'] as $index => $slide): $layout = $presentation['hero'][$index]; ?>
<?php include __DIR__ . '/components/home/hero-slide.php'; ?>
<?php endforeach; ?>
     </div>

     <div class="loading-spin dark large centered"></div>

	</div>

		</div>

	</section>

	<section class="section" id="section_733328052">
		<div class="section-bg fill" >

		</div>

		<div class="section-content relative">

<div class="row row-max-1500" id="row-1830793009">

	<div id="col-133004022" class="col small-12 large-12"  data-animate="fadeInLeft">
				<div class="col-inner"  >

	<div id="text-1062957703" class="text dtile">

<h2><?php foreach ($home['copy']['brands_heading'] as $lineIndex => $line): ?><?= $lineIndex === 0 ? '' : '<br class="br-mobile">' ?><?= e($line) ?><?php endforeach; ?></h2>

	</div>

		</div>

	</div>

	<div id="col-1939288690" class="col small-12 large-12"  data-animate="fadeInRight">
				<div class="col-inner"  >

    <div class="row home-brandlogo-slider lightbox-multi-gallery large-columns-5 medium-columns-3 small-columns-1 row-full-width slider row-slider slider-nav-simple slider-nav-outside"  data-flickity-options='{&quot;imagesLoaded&quot;: true, &quot;groupCells&quot;: &quot;100%&quot;, &quot;dragThreshold&quot; : 5, &quot;cellAlign&quot;: &quot;left&quot;,&quot;wrapAround&quot;: true,&quot;prevNextButtons&quot;: true,&quot;percentPosition&quot;: true,&quot;pageDots&quot;: true, &quot;rightToLeft&quot;: false, &quot;autoPlay&quot; : 3000}' >

  <?php foreach ($brands as $brand): ?>
<?php include __DIR__ . '/components/home/brand.php'; ?>
<?php endforeach; ?></div>
		</div>

	</div>

</div>
		</div>

	</section>

	<section class="section" id="section_165136154">
		<div class="section-bg fill" >

		</div>

		<div class="section-content relative">

<div class="row"  id="row-353129079">

	<div id="col-618367648" class="col medium-6 small-12 large-6"  data-animate="fadeInLeft">
				<div class="col-inner"  >

	<div id="text-3031624791" class="text dtsubtitle">

<p><?php foreach ($home['copy']['influence_eyebrow'] as $lineIndex => $line): ?><?= $lineIndex === 0 ? '' : '<br class="br-mobile">' ?><?= e($line) ?><?php endforeach; ?></p>
			</div>

	<div id="text-3966619878" class="text dtile">

<h2><?php foreach ($home['copy']['influence_heading'] as $lineIndex => $line): ?><?= $lineIndex === 0 ? '' : '<br class="br-mobile">' ?><?= e($line) ?><?php endforeach; ?></h2>

	</div>

		</div>

	</div>

	<div id="col-1212784119" class="col medium-6 small-12 large-6"  data-animate="fadeInRight">
				<div class="col-inner"  >

	<div id="text-505645133" class="text p-zero-margin">

<p><?php foreach ($home['copy']['influence_description'] as $lineIndex => $line): ?><?= $lineIndex === 0 ? '' : '<br class="br-mobile">' ?><?= e($line) ?><?php endforeach; ?></p>
			</div>

		</div>

	</div>

	<div id="col-855128820" class="col medium-6 small-12 large-6"  data-animate="fadeInLeft">
				<div class="col-inner"  >

  <div class="banner has-hover" id="banner-240184907">
          <div class="banner-inner fill">
        <div class="banner-bg fill" >
            <?php $image = $home['collections'][0]['image']; include __DIR__ . '/components/image.php'; ?>
                    </div>

        <div class="banner-layers container">
            <div class="fill banner-link"></div>

   <div id="text-box-2015974485" class="text-box banner-layer x50 md-x50 lg-x50 y50 md-y50 lg-y50 res-text">
                                <div class="text-box-content text dark">

              <div class="text-inner text-center">

              </div>
           </div>

    </div>

        </div>
      </div>

  </div>

		</div>

	</div>

	<div id="col-1334770715" class="col divider-on medium-6 small-12 large-6"  data-animate="fadeInUp">
				<div class="col-inner"  >

	<div id="text-2450199989" class="text dtsubtitle2">

<p><?php foreach ($home['copy']['social_milestone'] as $lineIndex => $line): ?><?= $lineIndex === 0 ? '' : '<br class="br-mobile">' ?><?= e($line) ?><?php endforeach; ?></p>

	</div>

	<div id="gap-560321887" class="gap-element clearfix">

	</div>

	<div id="stack-3701893570" class="stack home-stack-social stack-row justify-start items-stretch">

	<div class="img has-hover x md-x lg-x y md-y lg-y" id="image_1927864184">
		<a class="" href="<?= e($settings['contact']['fanpage']) ?>" target="_blank" rel="noopener nofollow">						<div class="img-inner dark" >
			<img decoding="async" src="/assets/images/fb-icon.svg" class="attachment-large size-large" alt="Facebook DuVin" title="Facebook DuVin">
					</div>
						</a>
	</div>

	<div class="img has-hover x md-x lg-x y md-y lg-y" id="image_1831423319">
		<a class="" href="<?= e($settings['contact']['zalo_oa']) ?>" target="_blank" rel="noopener nofollow">						<div class="img-inner dark" >
			<img decoding="async" src="/assets/images/zalo1-icon.png" class="attachment-large size-large" alt="Zalo DuVin" title="Zalo DuVin">
					</div>
						</a>
	</div>

	</div>

	<div id="gap-1112070631" class="gap-element clearfix">

	</div>

<div class="is-divider divider clearfix divider-olive"></div>

	<div id="gap-1982491605" class="gap-element clearfix">

	</div>

	<div id="stack-3637927383" class="stack stack-bignum stack-row justify-start items-stretch">

<?php foreach ($home['statistics'] as $index => $statistic): $statLayout = $presentation['statistics'][$index]; ?>
<?php include __DIR__ . '/components/home/statistic.php'; ?>
<?php endforeach; ?>

	</div>

		</div>

	</div>

</div>
		</div>

	</section>

	<section class="section home-section-choosewhisky dark" id="section_1632202293">
		<div class="section-bg fill" >

		</div>

		<div class="section-content relative">

<div class="row row-collapse row-full-width"  id="row-274672475">

	<div id="col-1821239223" class="col small-12 large-12"  data-animate="fadeInUp">
				<div class="col-inner"  >

		<div class="tabbed-content home-tab-choosewhisky">

			<ul class="nav nav-simple nav-uppercase nav-size-normal nav-left" role="tablist"><?php foreach ($home['category_tabs'] as $index => $tab): $layout = $presentation['tabs'][$index]; ?>
<li id="<?= e($layout['tab_id']) ?>" class="tab <?= $index === 0 ? 'active ' : '' ?>has-icon" role="presentation"><a href="#<?= e($layout['panel_id']) ?>" role="tab" aria-selected="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="<?= e($layout['panel_id']) ?>"><span><?= e($tab['title']) ?></span></a></li>
<?php endforeach; ?></ul><div class="tab-panels"><?php foreach ($home['category_tabs'] as $index => $tab): $layout = $presentation['tabs'][$index]; ?>
<div id="<?= e($layout['panel_id']) ?>" class="panel <?= $index === 0 ? 'active ' : '' ?>entry-content" role="tabpanel" aria-labelledby="<?= e($layout['tab_id']) ?>">
<?php include __DIR__ . '/components/home/category-banner.php'; ?>
</div>
<?php endforeach; ?></div></div>
	<div id="text-271047807" class="text dtsubtitle">

<p><?php foreach ($home['copy']['regions_heading'] as $lineIndex => $line): ?><?= $lineIndex === 0 ? '' : '<br class="br-mobile">' ?><?= e($line) ?><?php endforeach; ?></p>
			</div>

<a href="/danh-muc/wine" class="button white is-outline choosetype-seemore" >
		<span>Khám phá sản phẩm</span>
	</a>

		</div>
					</div>

</div>
		</div>

	</section>

	<section class="section" id="section_1899544034">
		<div class="section-bg fill" >

		</div>

		<div class="section-content relative">

<div class="row row-collapse row-full-width"  id="row-176228329">

	<div id="col-2023850650" class="col overflow-colright-slider small-12 large-12"  data-animate="fadeInRight">
				<div class="col-inner"  >

<div class="slider-wrapper relative homeslider-whisky-range" id="slider-410928108" >
    <div class="slider slider-nav-dots-simple slider-nav-circle slider-nav-large slider-nav-dark slider-nav-outside slider-style-normal"
        data-flickity-options='{
            "cellAlign": "left",
            "imagesLoaded": true,
            "lazyLoad": 1,
            "freeScroll": false,
            "wrapAround": false,
            "autoPlay": 3500,
            "pauseAutoPlayOnHover" : true,
            "prevNextButtons": false,
            "contain" : true,
            "adaptiveHeight" : true,
            "dragThreshold" : 10,
            "percentPosition": true,
            "pageDots": true,
            "rightToLeft": false,
            "draggable": true,
            "selectedAttraction": 0.1,
            "parallax" : 0,
            "friction": 0.6        }'
        >

  <?php foreach ($home['price_slides'] as $index => $slide): $layout = $presentation['price'][$index]; ?>
<?php include __DIR__ . '/components/home/price-slide.php'; ?>
<?php endforeach; ?>

     </div>

     <div class="loading-spin dark large centered"></div>

	</div>

		</div>

	</div>

</div>
		</div>

	</section>

	<section class="section" id="section_451098536">
		<div class="section-bg fill" >

		</div>

		<div class="section-content relative">

<div class="row"  id="row-1677677110">

	<div id="col-1065571273" class="col small-12 large-12"  data-animate="fadeInLeft">
				<div class="col-inner"  >

	<div id="text-2557870156" class="text dtsubtitle">

<p><?php foreach ($home['copy']['gifts_eyebrow'] as $lineIndex => $line): ?><?= $lineIndex === 0 ? '' : '<br class="br-mobile">' ?><?= e($line) ?><?php endforeach; ?></p>
			</div>

	<div id="text-143498331" class="text dtile">

<h2><?php foreach ($home['copy']['gifts_heading'] as $lineIndex => $line): ?><?= $lineIndex === 0 ? '' : '<br class="br-mobile">' ?><?= e($line) ?><?php endforeach; ?></h2>

	</div>

		</div>

	</div>

	<div id="col-842419818" class="col small-12 large-12"  data-animate="fadeInRight">
				<div class="col-inner"  >

<div class="row banner-linear-bottom"  id="row-251649603">

	<div id="col-20533896" class="col medium-6 small-12 large-6"  >
				<div class="col-inner"  >

  <div class="banner has-hover" id="banner-1158509399">
          <div class="banner-inner fill">
        <div class="banner-bg fill" >
            <?php $image = $home['collections'][1]['image']; include __DIR__ . '/components/image.php'; ?>                        <div class="overlay"></div>
                    </div>

        <div class="banner-layers container">
            <a class="fill" href="<?= e($home['collections'][1]['url_0']) ?>" ><div class="fill banner-link"></div></a>
   <div id="text-box-310536909" class="text-box banner-layer x50 md-x50 lg-x50 y95 md-y95 lg-y95 res-text">
                                <div class="text-box-content text dark">

              <div class="text-inner text-left">

	<div id="text-7382685" class="text dtsubtitle2">

<p><?= e($home['collections'][1]['text_0']) ?></p>

	</div>

	<div id="text-2312571193" class="text dtsubtitle2">

<p><?= e($home['collections'][1]['text_1']) ?></p>

	</div>

	<div id="gap-399557335" class="gap-element clearfix">

	</div>

<a href="<?= e($home['collections'][1]['url_1']) ?>" class="button white is-outline"  >
		<span>Khám phá sản phẩm</span>
	</a>

              </div>
           </div>

    </div>

        </div>
      </div>

  </div>

		</div>
					</div>

	<div id="col-732776585" class="col medium-6 small-12 large-6"  >
				<div class="col-inner"  >

  <div class="banner has-hover" id="banner-1939053351">
          <div class="banner-inner fill">
        <div class="banner-bg fill" >
            <?php $image = $home['collections'][2]['image']; include __DIR__ . '/components/image.php'; ?>                        <div class="overlay"></div>
                    </div>

        <div class="banner-layers container">
            <a class="fill" href="<?= e($home['collections'][2]['url_0']) ?>" ><div class="fill banner-link"></div></a>
   <div id="text-box-1841096281" class="text-box banner-layer x50 md-x50 lg-x50 y95 md-y95 lg-y95 res-text">
                                <div class="text-box-content text dark">

              <div class="text-inner text-left">

	<div id="text-3597991763" class="text dtsubtitle2">

<p><?= e($home['collections'][2]['text_0']) ?></p>

	</div>

	<div id="text-2071738324" class="text dtsubtitle2">

<p><?= e($home['collections'][2]['text_1']) ?></p>

	</div>

	<div id="gap-13144486" class="gap-element clearfix">

	</div>

<a href="<?= e($home['collections'][2]['url_1']) ?>" class="button white is-outline"  >
		<span>Khám phá sản phẩm</span>
	</a>

              </div>
           </div>

    </div>

        </div>
      </div>

  </div>

		</div>
					</div>

</div>
		</div>

	</div>

</div>
		</div>

	</section>

</div>

</main>

