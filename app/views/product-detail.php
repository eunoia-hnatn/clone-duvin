<?php include __DIR__ . '/layouts/header.php'; ?>
<main id="main" class="main page-wrapper">

	<div class="shop-container">


			<div class="container">
	<div class="woocommerce-notices-wrapper"></div></div>
<div id="product-detail" class="product type-product post-8516 status-publish first instock product_cat-old-rare has-post-thumbnail shipping-taxable product-type-simple">

	<div class="custom-product-page ux-layout-3390 ux-layout-scope-global">


	<section class="section product-mainsection" id="section_662777207">
		<div class="section-bg fill" >


	<div class="is-border"
		style="border-color:rgba(0, 0, 0, 0.1);border-width:0px 0px 1px 0px;">
	</div>

		</div>



		<div class="section-content relative">


<div class="row row-collapse row-full-width"  id="row-1028809157">


	<div id="col-533925693" class="col product-gallerycol medium-12 small-12 large-7"  data-animate="fadeInLeft">
				<div class="col-inner"  >




<div class="product-images relative mb-half has-hover woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-4 images" data-columns="4">

  <div class="badge-container is-larger absolute left top z-1">

</div>

  <div class="image-tools absolute top show-on-hover right z-3">
      </div>

  <div class="woocommerce-product-gallery__wrapper product-gallery-stacked product-gallery-slider slider slider-nav-small mb-half product-gallery-grid-layout product-gallery-grid-layout--1-2 slider-type-fade"
		  data-flickity-options='{
                "cellAlign": "center",
                "wrapAround": true,
                "autoPlay": false,
                "prevNextButtons": false,
                "adaptiveHeight": true,
                "imagesLoaded": true,
                "lazyLoad": 1,
                "dragThreshold" : 15,
                "pageDots": false,
                "rightToLeft": false       }'><?php foreach ($product['images'] as $imageIndex => $imageUrl): ?>
<div data-thumb="<?= e($imageUrl) ?>" data-thumb-alt="<?= e($product['name']) ?>" class="woocommerce-product-gallery__image slide <?= $imageIndex === 0 ? 'first' : '' ?>"><a href="<?= e($imageUrl) ?>"><img width="1920" height="1920" src="<?= e($imageUrl) ?>" class="wp-post-image ux-skip-lazy" alt="<?= e($product['name']) ?>" data-caption="" data-src="<?= e($imageUrl) ?>" data-large_image="<?= e($imageUrl) ?>" data-large_image_width="1920" data-large_image_height="1920" decoding="async" fetchpriority="high"></a></div>
<?php endforeach; ?></div>
</div>

<div class="show-for-medium product-gallery-stacked-thumbnails">
  </div>







		</div>
					</div>



	<div id="col-216841513" class="col product-infocol medium-12 small-12 large-5"  data-animate="fadeInUp">
				<div class="col-inner"  >



<div class="product-breadcrumb-container is-normal"><nav class="woocommerce-breadcrumb breadcrumbs uppercase"><a href="/">Trang chủ</a> <span class="divider">&#47;</span> <a href="/danh-muc/<?= $product['type'] === 'gift' ? 'bo-qua-tang' : 'wine' ?>/"><?= e($product['category_label']) ?></a></nav></div>

<div class="product-title-container"><h1 class="product-title product_title entry-title"><?= e($product['name']) ?></h1>

	<div class="is-divider small"></div>
</div>

<div class="product-short-description"><p><?= e($detail['short_description']) ?></p></div>




	<div id="stack-1376698824" class="stack stack-productaddition stack-row justify-start items-center sm:justify-between">


	<?php foreach ($detail['summary'] as $attribute): ?>
<div id="<?= e($attribute['id']) ?>" class="text"><p><?= e($attribute['label']) ?></p><p class="<?= $attribute['stock'] ? 'product-stock' : '' ?>"><?= e($attribute['stock'] ? ($product['in_stock'] ? 'Còn hàng' : 'Liên hệ') : $attribute['value']) ?></p></div>
<?php endforeach; ?>



<style>
#stack-1376698824 > * {
  --stack-gap: 0rem;
}
@media (min-width:550px) {
  #stack-1376698824 > * {
    --stack-gap: 1.5rem;
  }
}
</style>
	</div>

<div class="product-price-container is-normal"><div class="price-wrapper">
	<p class="price product-page-price ">
  <span class="woocommerce-Price-amount amount"><bdi><?= e(money($product['price'])) ?><span class="woocommerce-Price-currencySymbol">&#8363;</span></bdi></span></p>
</div>
</div>

<p><?= e($priceNote) ?></p>

<div class="add-to-cart-container form-normal is-normal"></div>

<a href="#engraving" class="button secondary expand product-engravingbtn hidden"  >
		<span>Tạo dấu ấn riêng với mỗi chai rượu</span>
	<i class="icon-angle-right" aria-hidden="true" ></i></a>






	<div id="gap-1389565787" class="gap-element clearfix" style="display:block; height:auto;">

<style>
#gap-1389565787 {
  padding-top: 10px;
}
</style>
	</div>


	<div id="text-626630188" class="text dtsubtitle2">


<p>Liên hệ để nhận tư vấn</p>

<style>
#text-626630188 {
  font-size: 1.2rem;
}
</style>
	</div>

	<div id="gap-494423407" class="gap-element clearfix" style="display:block; height:auto;">

<style>
#gap-494423407 {
  padding-top: 4px;
}
@media (min-width:550px) {
  #gap-494423407 {
    padding-top: 8px;
  }
}
</style>
	</div>


<div class="row row-collapse row-product-contact"  id="row-715045039">


	<div id="col-274049291" class="col medium-12 small-12 large-12"  >
				<div class="col-inner"  >



<a href="tel:+84589598386" target="_blank" class="button alert is-outline lowercase expand productcontact-phone" rel="noopener"  >
	<i class="icon-phone" aria-hidden="true" ></i>	<span>Điện thoại</span>
	</a>


<a href="https://zalo.me/0589598386" target="_blank" class="button alert is-outline lowercase expand productcontact-zalo" rel="noopener"  >
	<i class="icon-tumblr" aria-hidden="true" ></i>	<span>Zalo</span>
	</a>



		</div>

<style>
#col-274049291 > .col-inner {
  padding: 0px 0px 0px 0px;
}
</style>
	</div>



	<div id="col-1745960120" class="col medium-12 small-12 large-12"  >
				<div class="col-inner"  >



<a href="https://www.facebook.com/messages/t/DuVinVN" target="_blank" class="button alert is-outline lowercase expand productcontact-mess" rel="noopener"  >
	<i class="icon-envelop" aria-hidden="true" ></i>	<span>Messenger</span>
	</a>



		</div>

<style>
#col-1745960120 > .col-inner {
  padding: 0px 0px 0px 0px;
}
</style>
	</div>



</div>
	<div id="gap-2003885485" class="gap-element clearfix" style="display:block; height:auto;">

<style>
#gap-2003885485 {
  padding-top: 10px;
}
@media (min-width:550px) {
  #gap-2003885485 {
    padding-top: 20px;
  }
}
</style>
	</div>


	<div id="text-2474659932" class="text dtsubtitle2">


<p>Giá độc quyền trên website</p>

<style>
#text-2474659932 {
  font-size: 1.2rem;
}
</style>
	</div>

	<div id="gap-455441643" class="gap-element clearfix" style="display:block; height:auto;">

<style>
#gap-455441643 {
  padding-top: 4px;
}
@media (min-width:550px) {
  #gap-455441643 {
    padding-top: 8px;
  }
}
</style>
	</div>


<div class="row row-collapse row-product-usp"  id="row-1142872395">


	<?php foreach ($detail['benefits'] as $benefit): ?>
<?php include __DIR__ . '/components/catalog/benefit.php'; ?>
<?php endforeach; ?>



</div>


		</div>

<style>
#col-216841513 > .col-inner {
  padding: 30px 15px 30px 15px;
}
@media (min-width:550px) {
  #col-216841513 > .col-inner {
    padding: 40px 15px 40px 15px;
  }
}
@media (min-width:850px) {
  #col-216841513 > .col-inner {
    padding: 40px 4vw 40px 4vw;
  }
}
</style>
	</div>



</div>

		</div>


<style>
#section_662777207 {
  padding-top: 0px;
  padding-bottom: 0px;
}
</style>
	</section>


	<section class="section product-addinfosection" id="section_1937557866">
		<div class="section-bg fill" >



		</div>



		<div class="section-content relative">


<div class="row align-center"  id="row-1604706533">


	<div id="col-522956645" class="col small-12 large-12"  data-animate="fadeInRight">
				<div class="col-inner"  >



	<div id="text-407511146" class="text dtile2">


<h2>Thông tin sản phẩm</h2>

<style>
#text-407511146 {
  font-size: 1.6rem;
  text-align: center;
}
</style>
	</div>


		</div>

<style>
#col-522956645 > .col-inner {
  margin: 0px 0px -30px 0px;
}
@media (min-width:550px) {
  #col-522956645 > .col-inner {
    margin: 0px 0px -20px 0px;
  }
}
</style>
	</div>



	<div id="col-1694795184" class="col medium-10 small-12 large-10"  data-animate="fadeInLeft">
				<div class="col-inner"  >



	<div id="stack-2380280624" class="stack stack-productaddition stack-productaddition2 stack-row justify-center items-stretch sm:stack-col sm:justify-between">


	<div id="text-2781334535" class="text">


<p>Thương hiệu</p>
<p></p>
			</div>

	<div id="text-1334924153" class="text">


<p>Lọc lạnh</p>
<p></p>
			</div>

	<div id="text-1071949077" class="text">


<p>Vùng sản xuất</p>
<p>Speyside, Scotland</p>
			</div>

	<div id="text-4125158605" class="text">


<p>Loại thùng</p>
<p>Sherry Casks</p>
			</div>



<style>
#stack-2380280624 > * {
  --stack-gap: 0rem;
}
@media (min-width:550px) {
  #stack-2380280624 > * {
    --stack-gap: 1.5rem;
  }
}
</style>
	</div>


		</div>
					</div>



	<div id="col-297181629" class="col small-12 large-12"  data-animate="fadeInRight">
				<div class="col-inner"  >



<div class="row row-small align-equal row-productaddition3 row-mobile-scroll row-mobile-scroll-smallcol"  id="row-801306989">


	<?php foreach ($detail['specifications'] as $specification): ?>
<?php include __DIR__ . '/components/catalog/specification.php'; ?>
<?php endforeach; ?>




<style>
#row-801306989 > .col > .col-inner {
  padding: 20px 15px 20px 15px;
  background-color: rgba(152, 125, 79, 0.1);
}
@media (min-width:550px) {
  #row-801306989 > .col > .col-inner {
    padding: 25px 25px 25px 25px;
  }
}
</style>
</div>

		</div>

<style>
#col-297181629 > .col-inner {
  margin: 0px 0px -40px 0px;
}
</style>
	</div>



</div>

		</div>


<style>
#section_1937557866 {
  padding-top: 50px;
  padding-bottom: 50px;
}
@media (min-width:550px) {
  #section_1937557866 {
    padding-top: 80px;
    padding-bottom: 80px;
  }
}
</style>
	</section>


	<section class="section product-descripsection" id="section_1341289307">
		<div class="section-bg fill" >



		</div>



		<div class="section-content relative">


<div class="row align-center"  id="row-190604284">


	<div id="col-1408028579" class="col product-longdestitlecol small-12 large-12"  data-animate="fadeInRight">
				<div class="col-inner"  >



	<div id="text-3144955160" class="text dtile2">


<h2>Chi tiết sản phẩm</h2>

<style>
#text-3144955160 {
  font-size: 1.6rem;
  text-align: center;
}
</style>
	</div>


		</div>

<style>
#col-1408028579 > .col-inner {
  margin: 0px 0px -30px 0px;
}
@media (min-width:550px) {
  #col-1408028579 > .col-inner {
    margin: 0px 0px -20px 0px;
  }
}
</style>
	</div>



	<div id="col-41885415" class="col product-longdescol medium-7 small-12 large-7"  data-animate="fadeInUp">
				<div class="col-inner"  >




	<div class="woocommerce-tabs wc-tabs-wrapper container tabbed-content">
		<ul class="tabs wc-tabs product-tabs small-nav-collapse nav nav-uppercase nav-line nav-left" role="tablist">
							<li class="description_tab active" id="tab-title-description" role="presentation">
					<a href="#tab-description" role="tab" aria-selected="true" aria-controls="tab-description">
						Mô tả					</a>
				</li>
									</ul>
		<div class="tab-panels">
							<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--description panel entry-content active" id="tab-description" role="tabpanel" aria-labelledby="tab-title-description"><?php foreach ($detail['description_paragraphs'] as $paragraph): ?>
<p><?php foreach ($paragraph as $lineIndex => $fragments): ?><?= $lineIndex === 0 ? '' : '<br>' ?><?php foreach ($fragments as $fragment): ?><?php if (isset($fragment['url'])): ?><a href="<?= e($fragment['url']) ?>"><?= e($fragment['text']) ?></a><?php else: ?><?= e($fragment['text']) ?><?php endif; ?><?php endforeach; ?><?php endforeach; ?></p>
<?php endforeach; ?></div>

					</div>
	</div>




		</div>

<style>
#col-41885415 > .col-inner {
  margin: 0px 0px -40px 0px;
}
</style>
	</div>



</div>

		</div>


<style>
#section_1341289307 {
  padding-top: 50px;
  padding-bottom: 50px;
  background-color: #fcf7e8;
}
@media (min-width:550px) {
  #section_1341289307 {
    padding-top: 80px;
    padding-bottom: 80px;
  }
}
</style>
	</section>


	<section class="section product-rvsection" id="section_109242171">
		<div class="section-bg fill" >



		</div>



		<div class="section-content relative">


<div class="row"  id="row-1516556147">


	<div id="col-1231997220" class="col small-12 large-12"  data-animate="fadeInRight">
				<div class="col-inner"  >



	<div id="text-3905239603" class="text dtile2">


<h2>Đánh giá sản phẩm</h2>

<style>
#text-3905239603 {
  font-size: 1.6rem;
  text-align: center;
}
</style>
	</div>


		</div>

<style>
#col-1231997220 > .col-inner {
  margin: 0px 0px -30px 0px;
}
@media (min-width:550px) {
  #col-1231997220 > .col-inner {
    margin: 0px 0px -20px 0px;
  }
}
</style>
	</div>



	<div id="col-710833942" class="col small-12 large-12"  data-animate="fadeInUp">
				<div class="col-inner"  >





<div class="row"><p class="woocommerce-noreviews">Chưa có đánh giá nào.</p>
    <div class="col medium-6 small-12 large-5 product_review_form">
        <div class="col-inner">
		<div id="review_form_wrapper">
			<h2>
				Thêm đánh giá
			</h2>
            <div id="review_form">
                	<div id="respond" class="comment-respond">
		<span id="reply-title" class="comment-reply-title">Đánh giá sản phẩm &ldquo;<?= e($product['name']) ?>&rdquo; <small><a rel="nofollow" id="cancel-comment-reply-link" href="/san-pham/<?= e($product['slug']) ?>/#respond" style="display:none;">Hủy</a></small></span><form id="commentform" class="comment-form" novalidate><p class="comment-notes"><span id="email-notes">Email của bạn sẽ không được hiển thị công khai.</span> <span class="required-field-message">Các trường bắt buộc được đánh dấu <span class="required">*</span></span></p><div class="comment-form-rating"><label for="rating">Đánh giá của bạn</label><select name="rating" id="rating" required>
                                <option value="5">Rất tốt</option>
                                <option value="4">Tốt</option>
                                <option value="3">Trung bình</option>
                                <option value="2">Không tệ</option>
                                <option value="1">Rất tệ</option>
                            </select></div><p class="comment-form-comment"><label>Nhận xét của bạn *<textarea id="comment" name="comment" placeholder="Đánh giá sản phẩm..." cols="45" rows="8" required></textarea></label></p><p class="comment-form-author"><label>Họ và tên *<input id="author" name="author" type="text" value="" size="30" aria-required='true' placeholder="Họ và tên" /></label></p>
<p class="comment-form-email"><label>Địa chỉ Email *<input id="email" name="email" type="email" value="" size="30" aria-required='true' placeholder="Email" /></label></p>
<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" /> <label for="wp-comment-cookies-consent">Lưu tên của tôi, email, và trang web trong trình duyệt này cho lần bình luận kế tiếp của tôi.</label></p>
<div class="g-recaptcha" data-sitekey="6LfTg0oqAAAAAFkYneJLCazqfDBTVdg1pC0T5ajX"></div><p class="form-submit"><input type="submit" class="submit" value="Gửi đi" /> <input type='hidden' name='comment_post_ID' value='<?= (int) $product['id'] ?>' id='comment_post_ID' />
<input type='hidden' name='comment_parent' id='comment_parent' value='0' />
</p></form>	</div><!-- #respond -->
					<script type="text/javascript">
					jQuery( document ).ready(function() {
					jQuery('body.single-product p.comment-form-cookies-consent label').text('Lưu Tên và Email cho lần đánh giá kế tiếp');
				});
				</script>
            </div>
        </div>
		</div>
    </div>
	</div>



		</div>

<style>
#col-710833942 > .col-inner {
  margin: 0px 0px -45px 0px;
}
</style>
	</div>



</div>

		</div>


<style>
#section_109242171 {
  padding-top: 50px;
  padding-bottom: 50px;
}
@media (min-width:550px) {
  #section_109242171 {
    padding-top: 80px;
    padding-bottom: 80px;
  }
}
</style>
	</section>


	<section class="section" id="section_1373731494">
		<div class="section-bg fill" >


	<div class="is-border"
		style="border-color:rgba(0, 0, 0, 0.2);border-width:1px 0px 1px 0px;">
	</div>

		</div>



		<div class="section-content relative">


<div class="row align-center"  id="row-50534166">


	<div id="col-960327437" class="col small-12 large-12"  data-animate="fadeInRight">
				<div class="col-inner"  >



	<div id="text-2193562122" class="text dtile2">

<h2>Câu hỏi thường gặp</h2>

<style>
#text-2193562122 {
  font-size: 1.6rem;
  text-align: center;
}
</style>
	</div>


		</div>

<style>
#col-960327437 > .col-inner {
  margin: 0px 0px -20px 0px;
}
@media (min-width:550px) {
  #col-960327437 > .col-inner {
    margin: 0px 0px -20px 0px;
  }
}
</style>
	</div>



	<div id="col-1782480515" class="col medium-7 small-12 large-7"  data-animate="fadeInUp">
				<div class="col-inner"  >



<div class="accordion product-faqmain"><?php foreach ($detail['faqs'] as $faqIndex => $question): ?>
<div id="<?= e($question['id']) ?>" class="accordion-item">
    <a id="<?= e($question['id']) ?>-label" class="accordion-title plain <?= $faqIndex === 0 ? 'active' : '' ?>" href="<?= e($question['anchor']) ?>" aria-expanded="<?= $faqIndex === 0 ? 'true' : 'false' ?>" aria-controls="<?= e($question['id']) ?>-content">
        <button class="toggle" aria-label="Chuyển đổi"><i class="icon-angle-down"></i></button><span><?= e($question['question']) ?></span>
    </a>
    <div id="<?= e($question['id']) ?>-content" class="accordion-inner" <?= $faqIndex === 0 ? 'style="display: block;"' : '' ?> aria-labelledby="<?= e($question['id']) ?>-label"><?= e($question['answer']) ?></div>
</div>
<?php endforeach; ?></div>

		</div>

<style>
#col-1782480515 > .col-inner {
  margin: 0px 0px -40px 0px;
}
</style>
	</div>



</div>


		</div>


<style>
#section_1373731494 {
  padding-top: 50px;
  padding-bottom: 50px;
}
@media (min-width:550px) {
  #section_1373731494 {
    padding-top: 80px;
    padding-bottom: 80px;
  }
}
</style>
	</section>


	<section class="section" id="section_800060131">
		<div class="section-bg fill" >



		</div>



		<div class="section-content relative">


<div class="row"  id="row-787922864">


	<div id="col-1113861066" class="col related-product-col small-12 large-12"  data-animate="fadeInRight">
				<div class="col-inner"  >




	<div class="related related-products-wrapper product-section">

					<h3 class="product-section-title container-width product-section-title-related pt-half pb-half uppercase">
				Sản phẩm tương tự			</h3>




    <div class="row large-columns-4 medium-columns-3 small-columns-2 row-small" >

		<?php foreach ($relatedProducts as $index => $cardProduct): ?>
<?php include __DIR__ . '/components/catalog/product-card.php'; ?>
<?php endforeach; ?>
		</div>
	</div>




		</div>

<style>
#col-1113861066 > .col-inner {
  margin: 0px 0px -60px 0px;
}
</style>
	</div>



</div>

		</div>


<style>
#section_800060131 {
  padding-top: 50px;
  padding-bottom: 50px;
}
@media (min-width:550px) {
  #section_800060131 {
    padding-top: 80px;
    padding-bottom: 80px;
  }
}
</style>
	</section>
				<div id="product-sidebar" class="mfp-hide">
				<div class="sidebar-inner">
					<div class="hide-for-off-canvas" style="width:100%"><ul class="next-prev-thumbs is-small nav-right text-right"><?php if ($relatedProducts !== []): $nextProduct = $relatedProducts[0]; ?>
<li class="prod-dropdown has-dropdown"><a href="/san-pham/<?= e($nextProduct['slug']) ?>/" rel="next" class="button icon is-outline circle"><i class="icon-angle-right"></i></a><div class="nav-dropdown"><a title="<?= e($nextProduct['name']) ?>" href="/san-pham/<?= e($nextProduct['slug']) ?>/"><img width="100" height="100" src="<?= e($nextProduct['image']) ?>" class="attachment-woocommerce_gallery_thumbnail size-woocommerce_gallery_thumbnail wp-post-image" alt="<?= e($nextProduct['name']) ?>" decoding="async" loading="lazy"></a></div></li>
<?php endif; ?></ul></div><aside id="text-3" class="widget widget_text"><span class="widget-title shop-sidebar">Lọc sản phẩm</span><div class="is-divider small"></div>			<div class="textwidget"></div>
		</aside>				</div>
			</div>

	</div>


</div>


	</div><!-- shop container -->


<script>
    document.getElementById('commentform').addEventListener('submit', function(e) {
        e.preventDefault(); // Chặn việc tự động chuyển trang
        alert('Cảm ơn bạn! Đánh giá đã được ghi nhận.');
        this.reset(); // Xóa trắng form
    });
</script>


</main>
<?php include __DIR__ . '/layouts/footer.php'; ?>
