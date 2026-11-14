<!DOCTYPE html>
<html lang="vi" prefix="og: https://ogp.me/ns#" class="loading-site no-js">
<head>
	<meta charset="UTF-8" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />

	<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?= htmlspecialchars($pageTitle ?? 'Duvin', ENT_QUOTES, 'UTF-8') ?></title>
<meta name="description" content="<?= htmlspecialchars($metaDescription ?? "Duvin - Bộ sưu tập rượu vang cao cấp từ khắp thế giới.", ENT_QUOTES) ?>"/>
<meta name="robots" content="follow, index"/>
<link rel="canonical" href="/" />
<meta property="og:locale" content="vi_VN" />
<meta property="og:type" content="website" />
<meta property="og:title" content="<?= htmlspecialchars($pageTitle ?? "Duvin - Fine Wine Collection", ENT_QUOTES) ?>" />
<meta property="og:description" content="<?= htmlspecialchars($metaDescription ?? "Duvin - Bộ sưu tập rượu vang cao cấp từ khắp thế giới.", ENT_QUOTES) ?>" />
<meta property="og:url" content="/" />
<meta property="og:site_name" content="Duvin" />
<meta property="og:image" content="/assets/images/duvin-logo-red-transparent.png" />
<meta property="og:image:secure_url" content="/assets/images/duvin-logo-red-transparent.png" />
<meta property="og:image:alt" content="Trang chủ" />
<meta property="og:image:type" content="image/png" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="<?= htmlspecialchars($pageTitle ?? "Duvin - Fine Wine Collection", ENT_QUOTES) ?>" />
<meta name="twitter:description" content="<?= htmlspecialchars($metaDescription ?? "Duvin - Bộ sưu tập rượu vang cao cấp từ khắp thế giới.", ENT_QUOTES) ?>" />
<meta name="twitter:image" content="/assets/images/duvin-logo-red-transparent.png" />
<meta name="google-site-verification" content="3LookEWzoGNdmAyJfGf5uUmwLLe9gjD2dlEETCcZdkY" />

<link href='https://fonts.gstatic.com' crossorigin rel='preconnect' />

<link rel='stylesheet' id='contact-form-7-css' href="/assets/css/styles.css" type='text/css' media='all' />
<link rel='stylesheet' id='flatsome-main-css' href="/assets/css/flatsome.css" type='text/css' media='all' />
<link rel='stylesheet' id='flatsome-shop-css' href="/assets/css/flatsome-shop.css" type='text/css' media='all' />
<link rel='stylesheet' id='flatsome-style-css' href="/assets/css/style.css" type='text/css' media='all' />
<link rel='stylesheet' id='dashicons-css' href="/assets/css/dashicons.min.css" type='text/css' media='all' />
<link rel='stylesheet' id='flatsome-googlefonts-css' href='https://fonts.googleapis.com/css?family=Lato%3Aregular%2C700%2Cregular%2C700%7CDancing+Script%3Aregular%2Cregular&amp;display=block&amp;ver=3.9' type='text/css' media='all' />
<link rel='stylesheet' id='fs-tuned-animation-style-css' href="/assets/css/fs-tuned-animation.css" type='text/css' media='all' />
<script type="text/javascript" src="/assets/js/jquery.min.js" id="jquery-core-js"></script>

<link rel="icon" href="/assets/images/cropped-favicon.png" sizes="32x32" />
<link rel="icon" href="/assets/images/cropped-favicon.png" sizes="192x192" />
<link rel="apple-touch-icon" href="/assets/images/cropped-favicon.png" />
<meta name="msapplication-TileImage" content="/assets/images/cropped-favicon.png" />

	<!-- Duvin stylesheets -->
	<link rel="stylesheet" href="/assets/css/home.css" />
	<link rel="stylesheet" href="/assets/css/legacy-flatsome.css" />
	<link rel="stylesheet" href="/assets/css/duvin-light.css" />
	<link rel="stylesheet" href="/assets/css/age-gate.css" />
	<link rel="stylesheet" href="/assets/css/pdp.css" />
	<link rel="stylesheet" href="/assets/css/products.css" />
	<link rel="stylesheet" href="/assets/css/about.css" />
	<link rel="stylesheet" href="/assets/css/founder.css" />
	<link rel="stylesheet" href="/assets/css/blog.css" />
</head>
<body class="<?= isset($body_class) ? htmlspecialchars($body_class) : 'home page-template page-template-page-blank page-template-page-blank-php page page-id-21' ?> theme-flatsome header-shadow lightbox nav-dropdown-has-shadow catalog-mode">

	<header id="header" class="header header-full-width has-sticky sticky-shrink">
		<div class="header-wrapper">
			<div id="top-bar" class="header-top hide-for-sticky nav-dark">
    <div class="flex-row container">
      <div class="flex-col hide-for-medium flex-left">
          <ul class="nav nav-left medium-nav-center nav-small  nav-divided">
                        </ul>
      </div>

      <div class="flex-col hide-for-medium flex-center">
          <ul class="nav nav-center nav-small  nav-divided">
                        </ul>
      </div>

      <div class="flex-col hide-for-medium flex-right">
         <ul class="nav top-bar-nav nav-right nav-small  nav-divided">
              <li class="header-contact-wrapper">
		<ul id="header-contact" class="nav nav-divided nav-uppercase header-contact"><?php $menuItems = $site['menus']['header_contact']; include __DIR__ . '/../components/menu-items.php'; ?></ul>
</li>
          </ul>
      </div>

            <div class="flex-col show-for-medium flex-grow">
          <ul class="nav nav-center nav-small mobile-nav  nav-divided">
              <li class="header-contact-wrapper">
		<ul id="header-contact" class="nav nav-divided nav-uppercase header-contact"><?php $menuItems = $site['menus']['header_contact']; include __DIR__ . '/../components/menu-items.php'; ?></ul>
</li>
          </ul>
      </div>

    </div>
</div>
<div id="masthead" class="header-main show-logo-center">
      <div class="header-inner flex-row container logo-center medium-logo-center" role="navigation">

          <!-- Logo -->
          <div id="logo" class="flex-col logo">
			<!-- Header logo -->
<a href="/" title="Duvin" rel="home">
		<img src="/assets/images/duvin-logo-red-transparent.png" class="header_logo header-logo header-logo-img"
		alt="DuVin Logo"/><img src="/assets/images/duvin-logo-red-transparent.png" class="header-logo-dark header-logo-img" alt="DuVin Logo"/></a>
          </div>

          <!-- Mobile Left Elements -->
          <div class="flex-col show-for-medium flex-left">
            <ul class="mobile-nav nav nav-left ">
              <li class="nav-icon has-icon">
  		<a href="#" data-open="#main-menu" data-pos="left" data-bg="main-menu-overlay" data-color="" class="is-small" aria-label="Menu" aria-controls="main-menu" aria-expanded="false">

		  <i class="icon-menu" ></i>
		  		</a>
	</li>
            </ul>
          </div>

          <!-- Left Elements -->
          <div class="flex-col hide-for-medium flex-left
            ">
            <ul class="header-nav header-nav-main nav nav-left  nav-size-large nav-spacing-large nav-uppercase" >
              <li class="header-search-form search-form html relative has-icon">
	<div class="header-search-form-wrapper">
		<div class="searchform-wrapper ux-search-box relative form-flat is-normal"><form role="search" method="get" class="searchform" action="/san-pham">
	<div class="flex-row relative">
						<div class="flex-col flex-grow">
			<label class="screen-reader-text" for="duvin-search-field-0">Tìm kiếm:</label>
			<input type="search" id="duvin-search-field-0" class="search-field mb-0" placeholder="Tìm kiếm sản phẩm" value="" name="s" />
			<input type="hidden" name="post_type" value="product" />
					</div>
		<div class="flex-col">
			<button type="submit" value="Tìm kiếm" class="ux-search-submit submit-button secondary button  icon mb-0" aria-label="Gửi">
				<i class="icon-search" ></i>			</button>
		</div>
	</div>
	<div class="live-search-results text-left z-top"></div>
</form>
</div>	</div>
</li>
            </ul>
          </div>

          <!-- Right Elements -->
          <div class="flex-col hide-for-medium flex-right">
            <ul class="header-nav header-nav-main nav nav-right  nav-size-large nav-spacing-large nav-uppercase"><?php $menuItems = $site['menus']['header_2']; include __DIR__ . '/../components/menu-items.php'; ?></ul>
          </div>

          <!-- Mobile Right Elements -->
          <div class="flex-col show-for-medium flex-right">
            <ul class="mobile-nav nav nav-right ">
              <li class="header-search header-search-lightbox has-icon">
			<a href="#search-lightbox" aria-label="Tìm kiếm" data-open="#search-lightbox" data-focus="input.search-field"
		class="is-small">
		<i class="icon-search nav-icon-search"></i></a>

	<div id="search-lightbox" class="mfp-hide dark text-center">
		<div class="searchform-wrapper ux-search-box relative form-flat is-large"><form role="search" method="get" class="searchform" action="/san-pham">
	<div class="flex-row relative">
						<div class="flex-col flex-grow">
			<label class="screen-reader-text" for="duvin-search-field-1">Tìm kiếm:</label>
			<input type="search" id="duvin-search-field-1" class="search-field mb-0" placeholder="Tìm kiếm sản phẩm" value="" name="s" />
			<input type="hidden" name="post_type" value="product" />
					</div>
		<div class="flex-col">
			<button type="submit" value="Tìm kiếm" class="ux-search-submit submit-button secondary button  icon mb-0" aria-label="Gửi">
				<i class="icon-search" ></i>			</button>
		</div>
	</div>
	<div class="live-search-results text-left z-top"></div>
</form>
</div>	</div>
</li>
            </ul>
          </div>

      </div>

      </div>
<div id="wide-nav" class="header-bottom wide-nav flex-has-center hide-for-medium">
    <div class="flex-row container">


                        <div class="flex-col hide-for-medium flex-center">
                <ul class="nav header-nav header-bottom-nav nav-center  nav-size-large nav-spacing-large nav-uppercase"><?php $menuItems = $site['menus']['header_3']; include __DIR__ . '/../components/menu-items.php'; ?></ul>
            </div>



    </div>
</div>

<div class="header-bg-container fill"><div class="header-bg-image fill"></div><div class="header-bg-color fill"></div></div>
</div>
	</header>
