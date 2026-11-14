<?php
$footerContact = $settings['contact'];
$footerFanpage = $footerContact['fanpage'];
$footerZalo    = $footerContact['zalo_oa'];
$footerEmail   = $footerContact['email'];
$footerAddress = $footerContact['address'];
$footerPhone   = $footerContact['hotline_display'];
$footerTel     = $footerContact['hotline'];
?>
<footer id="footer" class="footer-wrapper">

	<section class="section" id="section_645310097">
		<div class="section-bg fill" >

		</div>

		<div class="section-content relative">

<div class="row"  id="row-604363842">

	<div id="col-54894707" class="col small-12 large-12"  data-animate="fadeInUp">
				<div class="col-inner"  >

<div class="row align-center"  id="row-967223584">

	<div id="col-672595123" class="col medium-9 small-12 large-9"  >
				<div class="col-inner text-center"  >

	<div class="img has-hover x md-x lg-x y md-y lg-y" id="image_109026919">
								<div class="img-inner dark" >
			<img src="/assets/images/duvin-logo-white-transparent.png" class="attachment-original size-original footer-logo-img"
			alt="DuVin Logo" decoding="async" loading="lazy" />
					</div>

	</div>

	<div id="gap-278321616" class="gap-element clearfix">

	</div>

	<div id="stack-2092229133" class="stack home-stack-social stack-row justify-center items-stretch">

	<div class="img has-hover x md-x lg-x y md-y lg-y" id="image_1395129220">
		<a class="" href="<?= htmlspecialchars($footerFanpage, ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener" >						<div class="img-inner dark" >
			<img src="/assets/images/fb-icon.svg" class="attachment-large size-large" alt="Facebook DuVin" decoding="async" loading="lazy" />
					</div>
						</a>
	</div>

	<div class="img has-hover x md-x lg-x y md-y lg-y" id="image_1831423319">
		<a class="" href="<?= htmlspecialchars($footerZalo, ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener nofollow">						<div class="img-inner dark" >
			<img decoding="async" src="/assets/images/zalo1-icon.png" class="attachment-large size-large" alt="Zalo DuVin" title="Zalo DuVin">
					</div>
						</a>
	</div>

	</div>

	<div id="gap-185281368" class="gap-element clearfix">

	</div>

<div class="row footer-contact"  id="row-1772542579">

	<div id="col-1501166594" class="col medium-3 small-12 large-3"  >
				<div class="col-inner"  >

	<div id="text-838481137" class="text">

<p><a href="mailto:<?= htmlspecialchars($footerEmail, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($footerEmail, ENT_QUOTES, 'UTF-8') ?></a></p>

	</div>

		</div>

	</div>

	<div id="col-2117228260" class="col medium-6 small-12 large-6"  >
				<div class="col-inner"  >

	<div id="text-2465876687" class="text">

<p><?= htmlspecialchars($footerAddress, ENT_QUOTES, 'UTF-8') ?></p>

	</div>

		</div>

	</div>

	<div id="col-1888979318" class="col medium-3 small-12 large-3"  >
				<div class="col-inner"  >

	<div id="text-3657797876" class="text">

<p><a href="tel:<?= htmlspecialchars($footerTel, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($footerPhone, ENT_QUOTES, 'UTF-8') ?></a></p>

	</div>

		</div>

	</div>

</div>

		</div>

	</div>

	<div id="col-1302614419" class="col medium-8 small-12 large-8"  >
				<div class="col-inner"  >

	<div id="text-1497284481" class="text dtsubtitle2">

<p>Chấp hành Nghị định số 105/2017/NĐ-CP của Chính phủ về kinh doanh rượu và các quy định về quản lý thương mại điện tử, Duvin không kinh doanh qua mạng internet các loại rượu, bia, đồ uống có cồn và không bán sản phẩm chứa cồn cho người dưới 18 tuổi. Website chỉ mang tính tham khảo và cung cấp thông tin về sản phẩm.</p>

	</div>

		</div>
					</div>

</div>

		</div>

	</div>

</div>
<div class="row row-collapse row-full-width"  id="row-256155669">

	<div id="col-790373404" class="col small-12 large-12"  data-animate="flipInX">
				<div class="col-inner"  >

	<div class="is-border footer-divider-border">
	</div>

	<div id="text-2404955144" class="text p-zero-margin dtsubtitle2">

<p>2026 © DUVIN. Mọi quyền đã được bảo lưu.</p>

	</div>

		</div>

	</div>

</div>

		</div>

	</section>

  </div>
</div>

</footer>

</div>

<div id="main-menu" class="mobile-sidebar no-scrollbar mfp-hide">

	<div class="sidebar-menu no-scrollbar ">

			<ul class="sidebar-menu-tabs flex nav nav-line-bottom nav-uppercase">
				<li class="sidebar-menu-tabs__tab active">
					<a class="sidebar-menu-tabs__tab-link" href="#">
						<span class="sidebar-menu-tabs__tab-text">Giới thiệu</span>
					</a>
				</li>
				<li class="sidebar-menu-tabs__tab">
					<a class="sidebar-menu-tabs__tab-link" href="#">
						<span class="sidebar-menu-tabs__tab-text">Sản phẩm</span>
					</a>
				</li>
			</ul>

			<ul class="nav nav-sidebar nav-vertical nav-uppercase hidden" data-tab="2"><?php $menuItems = $site['menus']['footer_0']; include __DIR__ . '/../components/menu-items.php'; ?></ul>
			<ul class="nav nav-sidebar nav-vertical nav-uppercase" data-tab="1"><?php $menuItems = $site['menus']['footer_1']; include __DIR__ . '/../components/menu-items.php'; ?></ul>

	</div>

</div>

<!-- Flatsome theme essential scripts -->
<script type="text/javascript" src="/assets/js/hoverIntent.min.js" id="hoverIntent-js"></script>
<script type="text/javascript" id="flatsome-js-js-extra">
/* <![CDATA[ */
var flatsomeVars = {"theme":{"version":"3.19.6"},"rtl":"","sticky_height":"80","stickyHeaderHeight":"0","scrollPaddingTop":"0","assets_url":"\/assets\/","lightbox":{"close_markup":"<button title=\"%title%\" type=\"button\" class=\"mfp-close\"><svg xmlns=\"http:\/\/www.w3.org\/2000\/svg\" width=\"28\" height=\"28\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"feather feather-x\"><line x1=\"18\" y1=\"6\" x2=\"6\" y2=\"18\"><\/line><line x1=\"6\" y1=\"6\" x2=\"18\" y2=\"18\"><\/line><\/svg><\/button>","close_btn_inside":false},"user":{"can_edit_pages":false},"i18n":{"mainMenu":"Menu ch\u00ednh","toggleButton":"Chuy\u1ec3n \u0111\u1ed5i"},"options":{"cookie_notice_version":"1","swatches_layout":false,"swatches_disable_deselect":false,"swatches_box_select_event":false,"swatches_box_behavior_selected":false,"swatches_box_update_urls":"1","swatches_box_reset":false,"swatches_box_reset_limited":false,"swatches_box_reset_extent":false,"swatches_box_reset_time":300,"search_result_latency":"500"},"is_mini_cart_reveal":"1"};
/* ]]> */
</script>
<script type="text/javascript" src="/assets/js/flatsome.js" id="flatsome-js-js"></script>
<script type="text/javascript" src="/assets/js/flatsome-instant-page.js" id="flatsome-instant-page-js"></script>
<script type="text/javascript" src="/assets/js/fs-tuned-animation.js" id="fs-tuned-animation-js-js"></script>
<script type="text/javascript" src="/assets/js/engraving.js" id="engraving-js-js"></script>

<script type="text/javascript" src="/assets/js/index.js" id="contact-form-7-js"></script>
<script type="text/javascript" src="/assets/js/frontend-script.js" id="frontend-script-js"></script>

<!-- Duvin script -->
<script src="/assets/js/home.js" defer></script>

<!-- Pusher Widget -->
<link rel="stylesheet" href="/assets/css/pusher.css" />
<?php include __DIR__ . '/../pusher.php'; ?>
<script src="/assets/js/pusher.js" defer></script>

<!-- Age Gate 18+ Modal -->
<?php include __DIR__ . '/../components/age-gate-modal.php'; ?>
<script src="/assets/js/age-gate.js" defer></script>

</body>
</html>
