<?php include __DIR__ . '/layouts/header.php'; ?>

<div class="blog-header-wrapper">
	<section class="section" id="section_671957014">
		<div class="section-bg fill">



		</div>



		<div class="section-content relative">



<div class="row row-collapse row-full-width align-equal" id="row-583254303">


	<div id="col-1785037370" class="col full-50center-col medium-6 small-12 large-6">
				<div class="col-inner dark" style="background-color:#636146;">



<div class="row row-collapse" id="row-514975268">


	<div id="col-793170825" class="col center-maxwidth-50 medium-12 small-12 large-12" data-animate="fadeInLeft" data-animate-transform="true" data-animate-transition="true" data-animated="true">
				<div class="col-inner">



		<div class="dtsubtitle dtbreadcrumb">


<nav aria-label="breadcrumbs" class="rank-math-breadcrumb"><p><a href="/">Trang chủ</a><span class="separator"> / </span><span class="last">Wine Knowledge</span></p></nav>
		</div>

	<div id="text-1612071350" class="text dtile">


<h2>KHÁM PHÁ THẾ GIỚI RƯỢU VANG BẤT TẬN</h2>

<style>
#text-1612071350 {
  font-size: 1.65rem;
}
</style>
	</div>

		<div class="p-zero-margin">


Nơi chia sẻ những kiến thức sâu sắc về các dòng rượu vang, quy trình ủ nho, nghệ thuật thưởng thức và những bí quyết ghép nối ẩm thực. Dù bạn là người mới bắt đầu hay một người sành vang thực thụ, bạn đều sẽ tìm thấy những thông tin hữu ích để nâng tầm trải nghiệm rượu vang của mình.
		</div>


		</div>
					</div>



</div>

		</div>
					</div>



	<div id="col-2017727275" class="col medium-6 small-12 large-6">
				<div class="col-inner">






  <div class="banner has-hover" id="banner-1003381553">
          <div class="banner-inner fill">
        <div class="banner-bg fill">
            <img width="1920" height="1280" src="/assets/images/duvin2.jpg" class="bg attachment-original size-original" alt="" decoding="async" fetchpriority="high">
                    </div>

        <div class="banner-layers container">
            <div class="fill banner-link"></div>               <div id="text-box-1377958019" class="text-box banner-layer x50 md-x50 lg-x50 y50 md-y50 lg-y50 res-text">
                     <div data-animate="fadeIn" data-animate-transform="true" data-animate-transition="true" data-animated="true">           <div class="text-box-content text dark">

              <div class="text-inner text-center">
                                </div>
           </div>
       </div>
<style>
#text-box-1377958019 {
  width: 60%;
}
#text-box-1377958019 .text-box-content {
  font-size: 100%;
}
@media (min-width:550px) {
  #text-box-1377958019 {
    width: 60%;
  }
}
</style>
    </div>
         </div>
      </div>


<style>
#banner-1003381553 {
  padding-top: 250px;
}
#banner-1003381553 .banner-bg img {
  object-position: 70% 88%;
}
@media (min-width:550px) {
  #banner-1003381553 {
    padding-top: 550px;
  }
}
</style>
  </div>




		</div>
					</div>



</div>

		</div>


<style>
#section_671957014 {
  padding-top: 0px;
  padding-bottom: 0px;
  background-color: #636146;
}
</style>
	</section>


	<section class="section" id="section_923242695">
		<div class="section-bg fill">



		</div>



		<div class="section-content relative">


	<div id="gap-402405711" class="gap-element clearfix" style="display:block; height:auto;">

<style>
#gap-402405711 {
  padding-top: 28px;
}
@media (min-width:550px) {
  #gap-402405711 {
    padding-top: 24px;
  }
}
</style>
	</div>


<div class="row" id="row-1593896295">


	<div id="col-792221550" class="col small-12 large-12" data-animate="fadeInRight" data-animate-transform="true" data-animate-transition="true" data-animated="true">
				<div class="col-inner">



<ul class="sidebar-wrapper ul-reset post-cat-widget"><div id="categories-2" class="widget widget_categories"><div class="widget-title-holder"><h3 class="widget-title">Danh mục bài viết</h3></div>
			<ul><?php foreach ($articleCategories as $articleCategory): ?>
<li class="<?= e($articleCategory['class']) ?>"><a href="<?= e($articleCategory['url']) ?>"><?= e($articleCategory['label']) ?></a> (<?= (int) $articleCategory['count'] ?>)</li>
<?php endforeach; ?></ul>

			</div></ul>


		</div>

<style>
#col-792221550 > .col-inner {
  margin: 0px 0px -30px 0px;
}
</style>
	</div>



</div>
<div class="row row-collapse row-full-width" id="row-698219946">


	<div id="col-302650768" class="col divider-on small-12 large-12">
				<div class="col-inner">



<div class="is-divider divider clearfix" style="margin-top:0px;margin-bottom:0px;max-width:100%;height:1px;background-color:rgba(99, 97, 70, 0.4);"></div>


		</div>
					</div>



</div>

		</div>


<style>
#section_923242695 {
  padding-top: 0px;
  padding-bottom: 0px;
}
</style>
	</section>

	<div id="gap-1585682205" class="gap-element clearfix" style="display:block; height:auto;">

<style>
#gap-1585682205 {
  padding-top: 30px;
}
@media (min-width:550px) {
  #gap-1585682205 {
    padding-top: 40px;
  }
}
</style>
	</div>
	</div>


<main id="main" class="">

<div id="content" class="blog-wrapper blog-archive page-wrapper">

<div class="row align-center">
	<div class="large-12 col" data-animate="fadeInUp" data-animate-transform="true" data-animate-transition="true" data-animated="true">

		<div id="post-list">



    <div class="row large-columns-3 medium-columns- small-columns-1 row-normal">
  <?php foreach ($articles as $article): ?>
<?php include __DIR__ . '/components/content/article-card.php'; ?>
<?php endforeach; ?></div>
		<?php if ($pagination['pages'] > 1): ?>
<nav aria-label="Article pagination">
    <ul class="page-numbers nav-pagination links text-center">
        <?php for ($pageNumber = 1; $pageNumber <= $pagination['pages']; $pageNumber++): ?>
        <li>
            <?php if ($pageNumber === $pagination['page']): ?>
            <span aria-current="page" class="page-number current"><?= $pageNumber ?></span>
            <?php else: ?>
            <a class="page-number" href="<?= $pageNumber === 1 ? '/kien-thuc-whisky' : '/kien-thuc-whisky/page/' . $pageNumber ?>"><?= $pageNumber ?></a>
            <?php endif; ?>
        </li>
        <?php endfor; ?>
        <?php if ($pagination['page'] < $pagination['pages']): ?>
        <li><a aria-label="Next" class="next page-number" href="/kien-thuc-whisky/page/<?= $pagination['page'] + 1 ?>"><i class="icon-angle-right"></i></a></li>
        <?php endif; ?>
    </ul>
</nav>
<?php endif; ?>	</div>

	</div>

</div>


</div>


</main>

<?php include __DIR__ . '/layouts/footer.php'; ?>
