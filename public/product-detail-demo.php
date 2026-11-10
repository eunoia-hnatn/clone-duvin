<?php
/** Standalone UI demo. All specifications, prices and expert reviews are mock data.
 * Preview: php -S 127.0.0.1:8941 -t public (without the MVC router script).
 * No application bootstrap, repositories or existing templates are changed.
 */
declare(strict_types=1);
$esc = static fn($value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$money = static fn($value): string => number_format($value, 0, ',', '.') . '₫';
$product = [
    'name' => 'Victor Bérard Châteauneuf-du-Pape', 'producer' => 'Victor Bérard',
    'grape' => 'Grenache · Syrah · Mourvèdre', 'origin' => 'Rhône Valley, Pháp',
    'type' => 'Vang đỏ', 'volume' => '750 ml', 'image' => '/assets/images/wine1.jpg',
];
$vintages = [
    ['year'=>'2021', 'alcohol'=>'14,5%', 'classification'=>'Châteauneuf-du-Pape AOP', 'price'=>2850000,
     'description'=>'Một cuộc gặp gỡ giữa nét cổ điển của vùng Rhône và cá tính đậm đà của trái nho chín. Niên vụ 2021 gợi mở sự thanh lịch, cấu trúc cân bằng cùng hương gia vị tinh tế.',
     'color'=>'Đỏ ruby sâu, ánh tím nhẹ.', 'aroma'=>'Anh đào đen, mận chín và thảo mộc vùng Provence.', 'palate'=>'Trái cây đỏ tròn đầy, tannin mềm và một chút tiêu đen.', 'finish'=>'Dài, ấm áp với dư vị cam thảo và gia vị.'],
    ['year'=>'2020', 'alcohol'=>'15%', 'classification'=>'Châteauneuf-du-Pape AOP · Sélection', 'price'=>3150000,
     'description'=>'Niên vụ 2020 mang phong cách đầy đặn và giàu năng lượng. Những lớp hương trái cây đen, gỗ sồi và gia vị đan xen, phù hợp với một bữa tối chậm rãi cùng người thân.',
     'color'=>'Đỏ garnet đậm, ánh hồng ngọc.', 'aroma'=>'Mâm xôi đen, mứt mận, cacao và gỗ tuyết tùng.', 'palate'=>'Đậm đà, tannin chắc, vị quả chín cùng nốt chocolate đen.', 'finish'=>'Bền bỉ, gợi tiêu đen, cacao và hương gỗ.'],
    ['year'=>'2019', 'alcohol'=>'14%', 'classification'=>'Châteauneuf-du-Pape AOP · Réserve', 'price'=>3650000,
     'description'=>'Niên vụ 2019 thể hiện chiều sâu của thời gian: trái cây chín hòa cùng sắc thái da thuộc và thảo mộc khô. Một lựa chọn dành cho người yêu phong cách vang trưởng thành, hài hòa.',
     'color'=>'Đỏ garnet, viền gạch nhẹ.', 'aroma'=>'Anh đào khô, da thuộc, hoa khô và hương thảo.', 'palate'=>'Mượt mà, acid cân bằng, vị quả đỏ và khoáng chất.', 'finish'=>'Thanh lịch, kéo dài với dư vị đất và thảo mộc.'],
];
$current = $vintages[0];
$commitments = [
 ['truck','Giao hàng an toàn','Đóng gói chỉn chu, giao tận nơi.'],
 ['glass','Tư vấn chuyên nghiệp','Chọn chai vang hợp khẩu vị.'],
 ['shield','Cam kết chất lượng','Nguồn gốc rõ ràng, an tâm chọn.'],
 ['tag','Giá trị xứng đáng','Lựa chọn phù hợp ngân sách.'],
 ['gift','Quà tặng tinh tế','Gửi trao một lời chúc trọn vẹn.'],
 ['headset','Luôn đồng hành','Hỗ trợ trước và sau mua hàng.'],
];
$reviews = [
 ['score'=>95,'name'=>'The Wine Journal','quote'=>'Cấu trúc thanh lịch, trái cây hài hòa và hậu vị gia vị kéo dài. Một biểu đạt đầy cuốn hút của vùng Rhône.'],
 ['score'=>93,'name'=>'Duvin Tasting Panel','quote'=>'Một chai vang giàu chiều sâu nhưng dễ tiếp cận, lý tưởng để chia sẻ trong những bữa tối đặc biệt.'],
];
$faqs = [
 ['%s có hương vị như thế nào?', 'Hương vị thay đổi theo niên vụ. Hãy chọn năm thu hoạch ở phần thông tin sản phẩm và tham khảo Tasting Notes tương ứng bên dưới.'],
 ['Nên thưởng thức %s ở nhiệt độ nào?', 'Gợi ý phục vụ ở 16–18°C, mở trước khoảng 30–60 phút. Có thể dùng decanter tùy tình trạng và độ trưởng thành của chai.'],
 ['%s phù hợp với món ăn nào?', 'Gợi ý kết hợp cùng thịt bò nướng, cừu áp chảo, món hầm và phô mai trưởng thành.'],
 ['Có thể chọn %s làm quà tặng không?', 'Có. Duvin có thể tư vấn hộp quà, thiệp và cách đóng gói phù hợp với dịp tặng. Liên hệ để trao đổi trước khi đặt.'],
];
$related = [
 ['name'=>'Victor Bérard Côtes du Rhône', 'image'=>'/assets/images/wine3.jpg', 'producer'=>'Victor Bérard','grape'=>'Merlot','classification'=>'Côtes du Rhône AOP','price'=>1250000,'match'=>'Cùng nhà sản xuất'],
 ['name'=>'Rhône Collection · Grenache', 'image'=>'/assets/images/wine4.jpg', 'producer'=>'Rhône Collection','grape'=>'Grenache','classification'=>'Côtes du Rhône AOP','price'=>1850000,'match'=>'Cùng giống nho'],
 ['name'=>'Domaine des Collines · Syrah', 'image'=>'/assets/images/wine6.jpg', 'producer'=>'Domaine des Collines','grape'=>'Syrah','classification'=>'Rhône AOP','price'=>2450000,'match'=>'Cùng giống nho'],
 ['name'=>'Maison du Rhône · Réserve', 'image'=>'/assets/images/wine7.jpg', 'producer'=>'Maison du Rhône','grape'=>'Cabernet Sauvignon','classification'=>'Châteauneuf-du-Pape AOP','price'=>3250000,'match'=>'Cùng phân hạng'],
];
// Keep suggestions that share a producer, grape or classification with this product.
$related = array_filter($related, static fn($item) => $item['producer'] === $product['producer']
    || in_array($item['grape'], array_map('trim', explode('·', $product['grape'])), true)
    || $item['classification'] === $current['classification']);
$iconPaths = [
 'truck'=>'M1 5h13v12H1z M14 9h5l4 4v4h-9 M5 17a2 2 0 1 0 0 4 2 2 0 0 0 0-4 M18 17a2 2 0 1 0 0 4 2 2 0 0 0 0-4',
 'glass'=>'M7 2h10l1 7a6 6 0 0 1-12 0z M12 15v7 M8 22h8 M6 8h12',
 'shield'=>'M12 2 3 6v6c0 5 9 10 9 10s9-5 9-10V6z M8 12l3 3 5-6',
 'tag'=>'M3 3h8l10 10-8 8L3 11z M7 7h.01',
 'gift'=>'M3 8h18v4H3z M5 12v10h14V12 M12 8v14 M12 8C2 8 5-2 12 8c7-10 10 0 0 0',
 'headset'=>'M3 14v-3a9 9 0 0 1 18 0v3 M3 12h4v8H3z M17 12h4v8h-4z M21 20c0 2-4 2-7 2',
 'share'=>'M18 2v14 M13 7l5-5 5 5 M10 5H3v17h18v-5',
];
$icon = static function(string $key) use ($iconPaths, $esc): string {
 return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.35" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="'.$esc($iconPaths[$key]).'"/></svg>';
};
?>
<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex,nofollow"><title><?= $esc($product['name']) ?> — Duvin Demo</title>
<link rel="icon" href="/assets/images/duvin-logo-red-transparent.png">
<style>
@font-face{font-family:Montreal;src:url('/assets/fonts/SVN-Neue-Montreal-Regular.woff') format('woff');font-display:swap}
@font-face{font-family:Playfair;src:url('/assets/fonts/PlayfairDisplay-Regular.ttf') format('truetype');font-display:swap}
*{box-sizing:border-box} :root{--red:#a51e2c;--ink:#272520;--muted:#77746d;--line:#e8e4de;--cream:#f7f5f0}html{scroll-behavior:auto;scroll-padding-top:25px}body{margin:0;background:#fff;color:var(--ink);font:16px/1.65 Montreal,Arial,sans-serif}a{color:inherit;text-decoration:none}button,select{font:inherit}button,a,select,summary{-webkit-tap-highlight-color:transparent}button,a,select,summary{outline-offset:5px}button{cursor:pointer}img{display:block;max-width:100%;height:auto}svg{width:23px;height:23px}p{margin:0 0 16px}h1,h2,h3{font-weight:400;line-height:1.24;margin:0}h1,h2,.serif{font-family:Playfair,Georgia,serif}.container{width:min(1240px,calc(100% - 80px));margin:auto}.topbar{padding:7px 20px;text-align:center;background:var(--ink);color:#fff;font-size:11px;letter-spacing:1.5px}.header-inner{height:94px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid var(--line)}.brand img{width:71px;height:70px;object-fit:contain}.header-inner nav{display:flex;gap:31px;font-size:12px;letter-spacing:1.5px}.header-contact{font-size:13px;color:var(--muted)}.breadcrumb{display:flex;flex-wrap:wrap;gap:12px;font-size:12px;color:var(--muted);padding:26px 0}.breadcrumb span{color:#b4afa5}.hero{display:grid;grid-template-columns:1fr 1fr;gap:62px;align-items:start}.gallery{position:sticky;top:24px}.hero-image{position:relative;background:var(--cream);overflow:hidden}.hero-image img{width:100%;aspect-ratio:1/1.12;object-fit:cover}.image-label{position:absolute;top:20px;left:20px;background:#fff;padding:5px 13px;font-size:10px;letter-spacing:1.8px}.image-caption{display:flex;justify-content:space-between;gap:20px;padding:14px 0;font-size:11px;color:var(--muted)}.eyebrow{color:var(--red);font-size:11px;letter-spacing:2px;text-transform:uppercase;margin-bottom:13px}.info h1{font-size:39px;letter-spacing:-.8px;max-width:530px}.intro{color:var(--muted);font-size:14px;margin:15px 0 19px}.price-line{display:flex;align-items:center;justify-content:space-between;gap:16px}.price{font-size:28px;color:var(--red)}.share{display:flex;gap:8px;align-items:center;background:transparent;border:0;color:var(--muted);font-size:12px;padding:8px 0}.share svg{width:18px;height:18px}.tax-note{font-size:11px;color:var(--muted);margin:4px 0 22px}.attributes{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));border-top:1px solid var(--line);margin:0 0 23px}.attribute{padding:16px 10px 14px 0;border-bottom:1px solid var(--line);min-width:0}.attribute dt{font-size:11px;color:var(--muted);margin-bottom:5px}.attribute dd{font-size:13px;line-height:1.6;margin:0}.attribute select{width:100%;max-width:132px;padding:5px 8px;border:1px solid #c9c1b8;color:var(--red);background:#fff;border-radius:0}.info h2{font-family:Montreal,Arial,sans-serif;font-size:18px;margin-bottom:14px}.commitments{display:grid;grid-template-columns:repeat(3,1fr);border-top:1px solid var(--line);border-left:1px solid var(--line)}.commitment{border-right:1px solid var(--line);border-bottom:1px solid var(--line);text-align:center;padding:16px 8px 12px}.commitment svg{color:var(--red);margin:0 auto 7px}.commitment strong{display:block;font-weight:400;font-size:12px}.commitment p{font-size:10px;line-height:1.5;color:var(--muted);margin:4px 0 0}.contact{padding-top:21px}.contact p{font-size:12px;color:var(--muted);margin:0 0 10px}.buttons{display:grid;grid-template-columns:1fr 1fr;gap:9px}.button{display:inline-flex;justify-content:center;align-items:center;gap:9px;min-height:43px;border:1px solid var(--red);padding:9px 16px;font-size:12px;letter-spacing:.5px;color:var(--red);background:#fff;transition:background .2s,color .2s}.button.primary,.button:hover{background:var(--red);color:#fff}.button.wide{grid-column:1/-1}.section{padding:70px 0;border-bottom:1px solid var(--line)}.section-heading{display:flex;justify-content:space-between;align-items:end;gap:20px;margin-bottom:32px}.section-heading h2{font-size:32px}.section-heading p{margin:0;color:var(--muted);font-size:13px}.details-section{background:var(--cream);margin-top:65px}.reading{max-width:980px}.detail-title{display:flex;justify-content:space-between;align-items:center;gap:20px;border-bottom:1px solid #d9d2c6;padding-bottom:22px;margin-bottom:30px}.detail-title h3{font-size:23px;font-family:Playfair,Georgia,serif}.vintage-tag{font-size:11px;letter-spacing:1px;color:var(--red);white-space:nowrap}.reading h3{font-family:Playfair,Georgia,serif;font-size:22px;margin-bottom:16px}.body-copy{font-size:15px;color:#625e56;line-height:1.9}.tasting{display:grid;grid-template-columns:repeat(4,1fr);margin:25px 0 36px;border:1px solid #ded8cf;background:#fff}.taste{padding:22px 20px;border-right:1px solid #ded8cf}.taste:last-child{border-right:0}.taste span{display:block;color:var(--red);font-size:10px;letter-spacing:2px;margin-bottom:15px}.taste h4{font-weight:400;font-size:13px;margin:0 0 10px}.taste p{font-size:13px;color:var(--muted);line-height:1.7;margin:0}.detail-columns{display:grid;grid-template-columns:1fr 1fr;gap:55px;margin-bottom:32px}.specs{margin:0}.specs div{display:grid;grid-template-columns:130px 1fr;gap:15px;padding:9px 0;border-bottom:1px solid #e1ddd5;font-size:13px}.specs dt{color:var(--muted)}.specs dd{margin:0}.editorial-block{margin-bottom:25px}.contact-strip{border-top:1px solid #d9d2c6;padding-top:22px;display:flex;flex-wrap:wrap;gap:12px 30px;font-size:12px;color:var(--muted)}.reviews{display:grid;grid-template-columns:1fr 1fr;gap:26px}.review{display:flex;gap:28px;border:1px solid var(--line);padding:30px}.score{color:var(--red);flex-shrink:0;text-align:center;font-family:Playfair,Georgia,serif;font-size:48px;line-height:1}.score small{display:block;font:10px Montreal,Arial,sans-serif;letter-spacing:1px;margin-top:10px}.review blockquote{margin:12px 0;color:var(--muted);font-size:14px;line-height:1.8}.review h3{font-size:14px}.mock-label{font-size:10px;color:var(--muted);margin-top:18px}.faq-wrap{display:grid;grid-template-columns:1fr 1.8fr;gap:80px}.faq-wrap h2{font-size:32px;margin-bottom:18px}.faq-intro{font-size:14px;color:var(--muted)}details{border-bottom:1px solid var(--line)}details:first-child{border-top:1px solid var(--line)}summary{padding:21px 28px 21px 0;font-size:14px;cursor:pointer;list-style:none;position:relative}summary::-webkit-details-marker{display:none}summary:after{content:'+';position:absolute;right:2px;color:var(--red);font-size:23px;top:14px}details[open] summary:after{content:'−'}details p{font-size:14px;color:var(--muted);padding-right:25px}.related .row{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:24px}.box-image{overflow:hidden;background:var(--cream)}.box-image img{width:100%;aspect-ratio:1;object-fit:cover;transition:transform .35s}.product-small:hover .box-image img{transform:scale(1.035)}.box-text{padding-top:15px}.product-cat{font-size:10px;letter-spacing:1.2px;color:var(--red);margin-bottom:6px}.name{font-family:Playfair,Georgia,serif;font-size:19px;line-height:1.4;margin-bottom:8px}.price-wrapper .price{font-size:16px;color:var(--ink)}.match{font-size:11px;color:var(--muted);margin:8px 0}.footer{background:#f7f6f3;text-align:center;padding:38px 20px}.footer img{height:75px;width:auto;margin:0 auto 20px}.footer p{font-size:11px;color:var(--muted)}.footer .legal{font-size:10px;margin-bottom:0}.toast{position:fixed;bottom:25px;left:50%;transform:translateX(-50%);z-index:20;background:var(--ink);color:#fff;padding:13px 22px;box-shadow:0 5px 30px #0002;font-size:14px;max-width:calc(100% - 32px);width:max-content}.toast:empty{display:none}.copy-fallback{background:var(--cream);padding:12px;margin-top:10px;font-size:12px}.copy-fallback input{width:100%;padding:8px;border:1px solid var(--line);margin-top:7px}.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}@media(min-width:1400px){.container{width:min(1300px,calc(100% - 120px))}.hero{gap:75px}.hero-image img{aspect-ratio:1/1.15}}@media(max-width:900px){.container{width:calc(100% - 40px)}.hero{gap:30px}.info h1{font-size:30px}.attributes{grid-template-columns:repeat(2,1fr)}.commitments{grid-template-columns:repeat(2,1fr)}.hero-image img{aspect-ratio:1/1.25}.review{gap:16px;padding:22px}.faq-wrap{gap:35px}.detail-columns{gap:30px}.tasting{grid-template-columns:repeat(2,1fr)}.taste{border-bottom:1px solid var(--line)}.taste:nth-child(2n){border-right:0}.taste:nth-child(n+3){border-bottom:0}.header-contact{display:none}}@media(max-width:600px){.container{width:calc(100% - 32px)}.topbar{font-size:9px;letter-spacing:.6px}.header-inner{height:78px}.brand img{height:60px;width:60px}.header-inner nav{gap:16px;font-size:10px;letter-spacing:.6px}.breadcrumb{font-size:10px;padding:18px 0}.hero{grid-template-columns:1fr;gap:20px}.gallery{position:static}.hero-image img{aspect-ratio:1}.info h1{font-size:34px}.attributes{grid-template-columns:repeat(3,1fr)}.commitments{grid-template-columns:repeat(3,1fr)}.price{font-size:26px}.section{padding:43px 0}.section-heading{align-items:start;flex-direction:column;gap:10px}.section-heading h2,.faq-wrap h2{font-size:28px}.details-section{margin-top:40px}.detail-title{align-items:start}.detail-title h3{font-size:21px}.detail-columns,.reviews,.faq-wrap{grid-template-columns:1fr;gap:25px}.review{padding:24px}.related .row{grid-template-columns:repeat(2,minmax(0,1fr));gap:24px 15px}.name{font-size:17px}.taste{padding:18px 14px}.toast{font-size:12px}.contact-strip{gap:9px}.header-inner nav a:last-child{display:none}}@media(prefers-reduced-motion:reduce){html{scroll-behavior:auto}*{transition:none!important}}

/* Demo-only additions: a centered reading flow and native, keyboard-accessible filters. */
[hidden]{display:none!important}
.support-column{display:flex;flex-direction:column;gap:25px}.support-column .contact{padding-top:0}
.row-product-contact .button{min-height:40px}.row-product-contact h2{font-size:15px}
.reading{max-width:860px}.details-section .section-heading{text-align:center;align-items:center;flex-direction:column;gap:14px}
.detail-title{justify-content:center;text-align:center}.detail-columns{grid-template-columns:1fr;gap:32px;margin-top:32px}
.description-toggle-wrap{text-align:center;margin-top:30px}.description-toggle-wrap .button{min-width:155px}
.related-filters{border:0;padding:0;margin:0;display:flex;flex-wrap:wrap;gap:10px}
.filter-pill{position:relative;cursor:pointer}.filter-pill input{position:absolute;opacity:0;width:1px;height:1px}
.filter-pill span{display:block;border:1px solid var(--line);padding:9px 17px;font-size:12px;color:var(--muted);transition:background .2s}
.filter-pill input:checked+span{background:var(--red);border-color:var(--red);color:white}
.filter-pill input:focus-visible+span{outline:2px solid var(--red);outline-offset:4px}
.filter-count{font-size:12px;color:var(--muted);margin:14px 0 22px}.empty-state{padding:24px;background:var(--cream);font-size:14px;color:var(--muted)}
@media(max-width:600px){.filter-pill span{padding:8px 12px}.related-filters{gap:8px}.reading{width:calc(100% - 32px)}}
</style>
</head>
<body>
<div class="topbar">THƯỞNG THỨC TINH TẾ · GỬI TRAO TRỌN VẸN</div>
<header class="container header-inner">
 <a class="brand" href="/" aria-label="Duvin — Trang chủ"><img src="/assets/images/duvin-logo-red-transparent.png" alt="Duvin"></a>
 <nav aria-label="Điều hướng chính"><a href="/danh-muc/wine/">WINE</a><a href="/danh-muc/old-rare/">OLD &amp; RARE</a><a href="/danh-muc/bo-qua-tang/">BỘ QUÀ TẶNG</a></nav>
 <a class="header-contact" href="tel:0589598386">Tư vấn · 058 959 8386</a>
</header>
<main id="product-detail-demo">
 <div class="container">
  <nav class="breadcrumb" aria-label="Breadcrumb"><a href="/">Trang chủ</a><span>/</span><a href="/danh-muc/wine/">Rượu vang</a><span>/</span><span>Victor Bérard</span></nav>
  <section class="hero row" aria-labelledby="product-name">
   <div class="gallery col product-gallerycol">
    <div class="hero-image product-images woocommerce-product-gallery"><span class="image-label">DUVIN SELECTION</span><img id="product-image" src="<?= $esc($product['image']) ?>" width="1600" height="1600" alt="<?= $esc($product['name']) ?> — ảnh minh họa" fetchpriority="high"></div>
    <div class="image-caption"><span>CHÂTEAUNEUF-DU-PAPE · RHÔNE VALLEY</span><span>750 ML</span></div>
   </div>
   <div class="info col product-infocol">
    <p class="eyebrow">Vang Pháp / Bộ sưu tập Rhône</p>
    <h1 id="product-name" class="product-title entry-title"><?= $esc($product['name']) ?></h1>
    <p class="intro">Dấu ấn vùng Rhône. Đậm đà, tinh tế và đầy cảm hứng.</p>
    <div class="price-line"><strong class="price" data-vintage="price"><?= $money($current['price']) ?></strong><button class="share" type="button" id="share-product"><?= $icon('share') ?> Chia sẻ sản phẩm</button></div>
    <p class="tax-note">Giá minh họa theo niên vụ · Liên hệ Duvin để được tư vấn chính xác.</p>
    <div id="copy-fallback" class="copy-fallback" hidden><label for="product-link">Không thể tự động sao chép. Bạn có thể sao chép liên kết này:</label><input id="product-link" type="text" readonly></div>
    <dl class="attributes">
     <div class="attribute"><dt>Nhà sản xuất</dt><dd><?= $esc($product['producer']) ?></dd></div>
     <div class="attribute"><dt><label for="vintage-select">Niên vụ</label></dt><dd><select id="vintage-select" aria-describedby="vintage-help"><?php foreach($vintages as $vintage): ?><option value="<?= $esc($vintage['year']) ?>"><?= $esc($vintage['year']) ?></option><?php endforeach; ?></select></dd></div>
     <div class="attribute"><dt>Nồng độ</dt><dd data-vintage="alcohol"><?= $esc($current['alcohol']) ?></dd></div>
     <div class="attribute"><dt>Giống nho</dt><dd><?= $esc($product['grape']) ?></dd></div>
     <div class="attribute"><dt>Đẳng cấp / Phân hạng</dt><dd data-vintage="classification"><?= $esc($current['classification']) ?></dd></div>
     <div class="attribute"><dt>Xuất xứ</dt><dd><?= $esc($product['origin']) ?></dd></div>
    </dl>
    <p id="vintage-help" class="sr-only">Đổi niên vụ để cập nhật giá, nồng độ, phân hạng, mô tả và hương vị.</p>
    <div class="support-column">
     <div class="contact row-product-contact"><h2>Liên hệ để nhận tư vấn</h2><div class="buttons">
      <a class="button alert is-outline lowercase expand productcontact-phone" href="tel:+84589598386"><span aria-hidden="true">☎</span> Điện thoại</a>
      <a class="button alert is-outline lowercase expand productcontact-zalo" href="https://zalo.me/0589598386" target="_blank" rel="noopener noreferrer">Zalo ↗</a>
      <a class="button alert is-outline lowercase expand productcontact-mess wide" href="https://www.facebook.com/messages/t/DuVinVN" target="_blank" rel="noopener noreferrer">Messenger ↗</a>
     </div></div>
     <div class="duvin-promises"><h2>Duvin có gì?</h2><div class="commitments"><?php foreach($commitments as [$symbol,$title,$description]): ?><div class="commitment"><?= $icon($symbol) ?><strong><?= $esc($title) ?></strong><p><?= $esc($description) ?></p></div><?php endforeach; ?></div></div>
    </div>
   </div>
  </section>
 </div>
 <section class="section details-section" aria-labelledby="detail-heading"><div class="container reading">
  <div class="section-heading"><div><p class="eyebrow">Khám phá từng tầng hương vị</p><h2 id="detail-heading">Chi tiết sản phẩm</h2></div><span class="vintage-tag">NIÊN VỤ <span data-vintage="year"><?= $esc($current['year']) ?></span></span></div>
  <div class="detail-title"><h3><?= $esc($product['name']) ?></h3></div>
  <h3>Giới thiệu tổng quan</h3><p class="body-copy" data-vintage="description"><?= $esc($current['description']) ?></p>
  <h3>Tasting Notes</h3><div class="tasting"><?php foreach(['color'=>'Màu sắc','aroma'=>'Mùi hương','palate'=>'Hương vị','finish'=>'Hậu vị'] as $key=>$label): ?><div class="taste"><span>0<?= array_search($key,['color','aroma','palate','finish'],true)+1 ?></span><h4><?= $esc($label) ?></h4><p data-vintage="<?= $esc($key) ?>"><?= $esc($current[$key]) ?></p></div><?php endforeach; ?></div>
  <div id="description-extra" hidden>
  <div class="detail-columns"><div><h3>Thông tin chi tiết sản phẩm</h3><dl class="specs">
   <?php foreach(['Tên sản phẩm'=>$product['name'],'Loại vang'=>$product['type'],'Giống nho'=>$product['grape'],'Vùng sản xuất'=>$product['origin'],'Nhà sản xuất'=>$product['producer'],'Dung tích'=>$product['volume']] as $label=>$value): ?><div><dt><?= $esc($label) ?></dt><dd><?= $esc($value) ?></dd></div><?php endforeach; ?>
   <?php foreach(['year'=>'Niên vụ','alcohol'=>'Nồng độ','classification'=>'Phân hạng'] as $key=>$label): ?><div><dt><?= $esc($label) ?></dt><dd data-vintage="<?= $esc($key) ?>"><?= $esc($current[$key]) ?></dd></div><?php endforeach; ?>
  </dl></div><div><div class="editorial-block"><h3>Bảo quản &amp; cách thưởng thức</h3><p class="body-copy">Bảo quản nơi mát, tránh ánh nắng trực tiếp và thay đổi nhiệt độ đột ngột. Gợi ý thưởng thức ở 16–18°C, mở trước 30–60 phút để rượu có thời gian phát triển hương vị.</p></div><div class="editorial-block"><h3>Sản phẩm dành cho ai?</h3><p class="body-copy">Dành cho người yêu vang đỏ có chiều sâu, những bữa tối sum họp và món quà tinh tế gửi đến người trân quý. Kết hợp cùng bò nướng, cừu hoặc phô mai trưởng thành.</p></div></div></div>
  <h3>Mua <?= $esc($product['name']) ?> chính hãng tại Việt Nam</h3><p class="body-copy">Đội ngũ Duvin đồng hành cùng bạn từ việc chọn niên vụ đến gợi ý thưởng thức và thiết kế quà tặng. Liên hệ để được xác nhận nguồn gốc, tình trạng sản phẩm và báo giá tại thời điểm mua.</p>
  <address id="contact-duvin" class="contact-strip" style="font-style:normal"><span>588 Võ Văn Dũng, Đống Đa, Hà Nội</span><a href="tel:0589598386">Hotline: 058 959 8386</a><a href="/">Website Duvin ↗</a></address>
  </div>
  <div class="description-toggle-wrap"><button id="description-toggle" class="button" type="button" aria-expanded="false" aria-controls="description-extra">Xem thêm <span aria-hidden="true">↓</span></button></div>
 </div></section>
 <section class="section"><div class="container"><div class="section-heading"><div><p class="eyebrow">Góc nhìn từ người am hiểu</p><h2>Đánh giá chuyên gia</h2></div><p>Tham khảo phong cách, tìm đúng gu.</p></div><div class="reviews"><?php foreach($reviews as $review): ?><article class="review"><div class="score"><?= $review['score'] ?><small>/100 PTS</small></div><div><h3><?= $esc($review['name']) ?></h3><blockquote>“<?= $esc($review['quote']) ?>”</blockquote><span class="mock-label">Điểm &amp; nhận xét minh họa · Niên vụ 2021</span></div></article><?php endforeach; ?></div><p class="mock-label">Bản demo: thông số, mức giá, nội dung đánh giá và hình ảnh gợi ý mang tính minh họa, chưa phải dữ liệu thương mại được xác minh.</p></div></section>
 <section class="section"><div class="container faq-wrap"><div><p class="eyebrow">Duvin giải đáp</p><h2>Câu hỏi thường gặp</h2><p class="faq-intro">Một vài điều bạn có thể muốn biết trước khi chọn chai vang của mình.</p></div><div><?php foreach($faqs as $index=>[$question,$answer]): ?><details <?= $index===0?'open':'' ?>><summary><?= $esc(sprintf($question,$product['name'])) ?></summary><p><?= $esc($answer) ?></p></details><?php endforeach; ?></div></div></section>
 <section id="related-section" class="section related related-products-wrapper product-section"><div class="container"><div class="section-heading"><div><p class="eyebrow">Tiếp nối hành trình khám phá</p><h2 class="product-section-title-related">Sản phẩm tương tự</h2></div><p>Cùng nhà sản xuất, giống nho hoặc phân hạng.</p></div>
 <fieldset class="related-filters"><legend class="sr-only">Gợi ý sản phẩm tương tự theo bộ lọc</legend>
 <?php foreach(['all'=>'Tất cả gợi ý','producer'=>'Cùng nhà sản xuất','grape'=>'Cùng giống nho','classification'=>'Cùng phân hạng'] as $value=>$label): ?><label class="filter-pill"><input type="radio" name="related-filter" value="<?= $esc($value) ?>" <?= $value==='all'?'checked':'' ?> aria-controls="related-grid"><span><?= $esc($label) ?></span></label><?php endforeach; ?>
 </fieldset>
 <p id="related-count" class="filter-count" role="status" aria-live="polite">4 sản phẩm phù hợp</p>
 <p id="related-empty" class="empty-state" hidden>Chưa có gợi ý phù hợp với bộ lọc và niên vụ này. Hãy chọn tiêu chí khác.</p>
 <!-- Reused grid and product-card HTML structure from app/views/product-detail.php and its catalog component. -->
 <div id="related-grid" class="row large-columns-4 medium-columns-3 small-columns-2 row-small"><?php foreach($related as $index=>$cardProduct): ?><article class="product-small col has-hover product type-product" data-related-card data-producer="<?= $esc($cardProduct['producer']) ?>" data-grape="<?= $esc($cardProduct['grape']) ?>" data-classification="<?= $esc($cardProduct['classification']) ?>"><div class="col-inner"><div class="product-small box"><div class="box-image"><div class="image-zoom"><a href="?suggestion=<?= $index+1 ?>#product-name" aria-label="Xem mẫu <?= $esc($cardProduct['name']) ?>" data-demo-suggestion><img width="800" height="800" src="<?= $esc($cardProduct['image']) ?>" alt="<?= $esc($cardProduct['name']) ?> — ảnh minh họa" loading="lazy"></a></div></div><div class="box-text box-text-products"><div class="title-wrapper"><p class="category uppercase product-cat">Vang đỏ · <?= $esc($cardProduct['producer']) ?></p><h3 class="name product-title woocommerce-loop-product__title"><a href="?suggestion=<?= $index+1 ?>#product-name" data-demo-suggestion><?= $esc($cardProduct['name']) ?></a></h3></div><div class="price-wrapper"><span class="price woocommerce-Price-amount"><?= $money($cardProduct['price']) ?></span><p class="match"><?= $esc($cardProduct['match']) ?></p></div></div></div></div></article><?php endforeach; ?></div>
 </div></section>
</main>
<footer class="footer"><img src="/assets/images/duvin-logo-red-transparent.png" width="80" height="80" alt="Duvin"><p>Thưởng thức có trách nhiệm. Không dành cho người dưới 18 tuổi.</p><p class="legal">© <?= date('Y') ?> DUVIN · BẢN DEMO GIAO DIỆN</p></footer>
<div id="demo-toast" class="toast" role="status" aria-live="polite" aria-atomic="true"></div>
<p id="vintage-announcement" class="sr-only" role="status" aria-live="polite"></p>
<script>
(() => {
 'use strict';
 // JavaScript array is generated from the inline PHP mocks, with no API dependencies.
 const vintages = <?= json_encode($vintages, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_THROW_ON_ERROR) ?>;
 const product = <?= json_encode($product, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_THROW_ON_ERROR) ?>;
 const root = document.getElementById('product-detail-demo');
 const select = document.getElementById('vintage-select');
 const toast = document.getElementById('demo-toast');
 let toastTimer;
 const showToast = message => {
  if (!toast) return;
  clearTimeout(toastTimer);
  toast.textContent = message;
  toastTimer = setTimeout(() => { toast.textContent = ''; }, 4000);
 };
 const descriptionExtra = document.getElementById('description-extra');
 const descriptionToggle = document.getElementById('description-toggle');
 if (descriptionExtra && descriptionToggle) {
  descriptionToggle.addEventListener('click', () => {
   const expanded = descriptionToggle.getAttribute('aria-expanded') !== 'true';
   descriptionExtra.hidden = !expanded;
   descriptionToggle.setAttribute('aria-expanded', String(expanded));
   descriptionToggle.textContent = expanded ? 'Thu gọn ↑' : 'Xem thêm ↓';
   if (!expanded) descriptionToggle.scrollIntoView({block:'nearest', behavior:'auto'});
  });
 }
 const filters = root ? Array.from(root.querySelectorAll('input[name="related-filter"]')) : [];
 const relatedCards = root ? Array.from(root.querySelectorAll('[data-related-card]')) : [];
 const relatedCount = document.getElementById('related-count');
 const relatedEmpty = document.getElementById('related-empty');
 const updateRelatedProducts = () => {
  const selected = filters.find(input => input.checked);
  const criterion = selected ? selected.value : 'all';
  const vintage = vintages.find(item => select && item.year === select.value) || vintages[0];
  const grapes = product.grape.split('·').map(value => value.trim());
  let visible = 0;
  relatedCards.forEach(card => {
   const matches = {
    producer: card.dataset.producer === product.producer,
    grape: grapes.includes(card.dataset.grape),
    classification: card.dataset.classification === vintage.classification
   };
   const match = criterion === 'all' ? Object.values(matches).some(Boolean) : matches[criterion] === true;
   card.hidden = !match;
   if (match) visible++;
  });
  if (relatedCount) relatedCount.textContent = `${visible} sản phẩm phù hợp${vintage ? ' · Niên vụ ' + vintage.year : ''}`;
  if (relatedEmpty) relatedEmpty.hidden = visible > 0;
 };
 filters.forEach(input => input.addEventListener('change', updateRelatedProducts));
 updateRelatedProducts();
 const formatPrice = value => new Intl.NumberFormat('vi-VN').format(value) + '₫';
 if (root && select) {
  select.addEventListener('change', () => {
   const vintage = vintages.find(item => item.year === select.value);
   if (!vintage) return;
   updateRelatedProducts();
   root.querySelectorAll('[data-vintage]').forEach(element => {
    const key = element.dataset.vintage;
    if (Object.prototype.hasOwnProperty.call(vintage, key)) {
     element.textContent = key === 'price' ? formatPrice(vintage[key]) : vintage[key];
    }
   });
   const announcement = document.getElementById('vintage-announcement');
   if (announcement) announcement.textContent = `Đã chọn niên vụ ${vintage.year}. Giá ${formatPrice(vintage.price)}. Thông tin và hương vị đã cập nhật.`;
  });
 }
 const shareButton = document.getElementById('share-product');
 if (shareButton) shareButton.addEventListener('click', async () => {
  const url = window.location.href;
  let copied = false;
  if (navigator.clipboard && window.isSecureContext) {
   try { await navigator.clipboard.writeText(url); copied = true; } catch (error) { /* Try legacy clipboard below. */ }
  }
  if (!copied) {
   const field = document.createElement('textarea');
   field.value = url;
   field.setAttribute('aria-label', 'Liên kết sản phẩm');
   field.style.cssText = 'position:fixed;left:-9999px;top:0';
   document.body.appendChild(field);
   field.select();
   try { copied = document.execCommand('copy'); } catch (error) { copied = false; }
   field.remove();
   shareButton.focus();
  }
  if (copied) {
   const fallback = document.getElementById('copy-fallback');
   if (fallback) fallback.hidden = true;
   showToast('Đã sao chép liên kết sản phẩm!');
  } else {
   const fallback = document.getElementById('copy-fallback');
   const input = document.getElementById('product-link');
   if (fallback && input) { fallback.hidden = false; input.value = url; input.focus(); input.select(); }
   showToast('Vui lòng sao chép liên kết trong ô bên dưới giá.');
  }
 });
 if (root) root.querySelectorAll('[data-demo-suggestion]').forEach(link => {
  link.addEventListener('click', event => {
   event.preventDefault();
   showToast('Sản phẩm gợi ý đang dùng dữ liệu minh họa trong bản demo.');
  });
 });
})();
</script>
</body>
</html>
