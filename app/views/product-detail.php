<?php
/**
 * Trang chi tiết sản phẩm (PDP) — DuVin
 * Khung chuẩn MVC, tách biệt logic & giao diện, bảo đảm an toàn XSS.
 */
declare(strict_types=1);

$vintages = [
    [
        'year' => '2021',
        'alcohol' => '14,5%',
        'classification' => 'Grand Cru Classé AOP',
        'price' => $product['price'],
        'description' => 'Một cuộc gặp gỡ giữa nét cổ điển và cá tính đậm đà của trái nho chín. Niên vụ 2021 gợi mở sự thanh lịch, cấu trúc cân bằng cùng hương gia vị tinh tế.',
        'color' => 'Đỏ ruby sâu, ánh tím nhẹ.',
        'aroma' => 'Anh đào đen, mận chín, gỗ sồi thanh lịch và thảo mộc vùng Provence.',
        'palate' => 'Trái cây đỏ tròn đầy, tannin mềm mượt và một chút tiêu đen.',
        'finish' => 'Kéo dài, ấm áp với dư vị cam thảo và gia vị tinh tế.'
    ],
    [
        'year' => '2020',
        'alcohol' => '15,0%',
        'classification' => 'Grand Cru Classé AOP · Sélection',
        'price' => (int) round($product['price'] * 1.1),
        'description' => 'Niên vụ 2020 mang phong cách đầy đặn và giàu năng lượng. Những lớp hương trái cây đen, gỗ sồi và gia vị đan xen, hậu vị sâu lắng và bền bỉ.',
        'color' => 'Đỏ garnet đậm, ánh hồng ngọc.',
        'aroma' => 'Mâm xôi đen, mứt mận, cacao và gỗ tuyết tùng.',
        'palate' => 'Đậm đà, tannin chắc, vị quả chín cùng nốt chocolate đen.',
        'finish' => 'Bền bỉ, gợi tiêu đen, cacao và hương gỗ sồi lâu năm.'
    ],
    [
        'year' => '2019',
        'alcohol' => '14,0%',
        'classification' => 'Grand Cru Classé AOP · Réserve',
        'price' => (int) round($product['price'] * 1.25),
        'description' => 'Niên vụ 2019 thể hiện trọn vẹn chiều sâu của thời gian: trái cây chín hòa cùng sắc thái da thuộc và thảo mộc khô quý phái. Lựa chọn tuyệt vời cho người sành vang.',
        'color' => 'Đỏ garnet, viền gạch nhẹ.',
        'aroma' => 'Anh đào khô, da thuộc, hoa khô và hương thảo.',
        'palate' => 'Mượt mà như nhung, acid cân bằng, vị quả đỏ và khoáng chất.',
        'finish' => 'Thanh lịch đỉnh cao, kéo dài với dư vị đất ẩm và thảo mộc.'
    ]
];
$currentVintage = $vintages[0];

$commitments = [
    ['truck', 'Giao hàng an toàn', 'Đóng gói chỉn chu, giao nhanh tận nơi.'],
    ['glass', 'Tư vấn chuyên nghiệp', 'Chọn chai vang đúng gu và mục đích.'],
    ['shield', 'Cam kết chính hãng', 'Nguồn gốc minh bạch, đầy đủ chứng nhận.'],
    ['tag', 'Giá trị xứng đáng', 'Mức giá cạnh tranh, ưu đãi thành viên.'],
    ['gift', 'Quà tặng tinh tế', 'Hộp quà sang trọng gửi trao lời chúc.'],
    ['headset', 'Đồng hành tận tâm', 'Hỗ trợ khách hàng trước và sau mua hàng.']
];

$reviews = [
    ['score' => 95, 'name' => 'The Wine Journal', 'quote' => 'Cấu trúc thanh lịch, trái cây hài hòa và hậu vị gia vị kéo dài. Một biểu đạt đầy cuốn hút của nghệ thuật làm vang.'],
    ['score' => 93, 'name' => 'Duvin Tasting Panel', 'quote' => 'Một chai vang giàu chiều sâu nhưng dễ tiếp cận, lý tưởng để sẻ chia trong những bữa tối sum vầy hoặc tiếp đãi đối tác.']
];

$faqs = [
    ['%s có hương vị như thế nào?', 'Hương vị biến chuyển theo từng niên vụ và giống nho. Quý khách có thể chọn niên vụ ở trên để tham khảo Tasting Notes chi tiết hoặc liên hệ chuyên viên Duvin để nhận tư vấn.'],
    ['Nên thưởng thức %s ở nhiệt độ nào?', 'Nhiệt độ phục vụ lý tưởng là 16–18°C. Khuyến nghị mở chai hoặc dùng decanter cho vang thở trước 30–60 phút để giải phóng tối đa hương thơm.'],
    ['%s phù hợp kết hợp với món ăn nào?', 'Rất tuyệt vời khi kết hợp cùng các món thịt đỏ (bò nướng, cừu áp chảo), sườn hun khói, thịt nguội cao cấp và phô mai trưởng thành.'],
    ['Có thể chọn %s làm quà tặng doanh nghiệp không?', 'Có. Duvin có sẵn các set hộp quà cao cấp, thiệp viết tay và phụ kiện thưởng vang, sẵn sàng thiết kế theo yêu cầu doanh nghiệp.']
];

$iconPaths = [
    'truck'   => 'M1 5h13v12H1z M14 9h5l4 4v4h-9 M5 17a2 2 0 1 0 0 4 2 2 0 0 0 0-4 M18 17a2 2 0 1 0 0 4 2 2 0 0 0 0-4',
    'glass'   => 'M7 2h10l1 7a6 6 0 0 1-12 0z M12 15v7 M8 22h8 M6 8h12',
    'shield'  => 'M12 2 3 6v6c0 5 9 10 9 10s9-5 9-10V6z M8 12l3 3 5-6',
    'tag'     => 'M3 3h8l10 10-8 8L3 11z M7 7h.01',
    'gift'    => 'M3 8h18v4H3z M5 12v10h14V12 M12 8v14 M12 8C2 8 5-2 12 8c7-10 10 0 0 0',
    'headset' => 'M3 14v-3a9 9 0 0 1 18 0v3 M3 12h4v8H3z M17 12h4v8h-4z M21 20c0 2-4 2-7 2',
    'share'   => 'M18 2v14 M13 7l5-5 5 5 M10 5H3v17h18v-5',
];

$renderIcon = static function (string $key) use ($iconPaths): string {
    $path = $iconPaths[$key] ?? '';
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.35" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="' . e($path) . '"/></svg>';
};
?>
<main id="product-detail-view" class="main page-wrapper">
    <div class="container">
        <!-- Breadcrumbs -->
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="/">Trang chủ</a>
            <span>/</span>
            <a href="/danh-muc/<?= $product['type'] === 'gift' ? 'bo-qua-tang' : 'wine' ?>/"><?= e($product['category_label'] ?? 'WINE') ?></a>
            <span>/</span>
            <span><?= e($product['name']) ?></span>
        </nav>

        <!-- Product Hero Section -->
        <section class="hero row" aria-labelledby="product-name">
            <!-- Left Gallery Column -->
            <div class="gallery col product-gallerycol">
                <div class="hero-image product-images woocommerce-product-gallery">
                    <span class="image-label">DUVIN SELECTION</span>
                    <img id="product-image" src="<?= e($product['image']) ?>" class="wp-post-image ux-skip-lazy" alt="<?= e($product['name']) ?>" width="1200" height="1200" fetchpriority="high">
                </div>
                <div class="image-caption">
                    <span>CHÍNH HÃNG NHẬP KHẨU</span>
                    <span>750 ML</span>
                </div>
            </div>

            <!-- Right Info Column -->
            <div class="info col product-infocol">
                <p class="eyebrow"><?= e($product['category_label'] ?? 'RƯỢU VANG CAO CẤP') ?></p>
                <h1 id="product-name" class="product-title entry-title"><?= e($product['name']) ?></h1>
                <p class="intro">Tuyển chọn vang cao cấp từ Duvin. Đậm đà, tinh tế và gợi mở những xúc cảm trọn vẹn.</p>

                <div class="price-line">
                    <strong class="price" data-vintage="price"><?= e(money($product['price'])) ?>₫</strong>
                    <button class="share" type="button" id="share-product" aria-label="Chia sẻ liên kết sản phẩm">
                        <?= $renderIcon('share') ?> Chia sẻ sản phẩm
                    </button>
                </div>
                <p class="tax-note"><?= e($priceNote ?? 'Giá đã bao gồm thuế VAT · Liên hệ Duvin để nhận tư vấn chính xác.') ?></p>

                <!-- Fallback Share Box -->
                <div id="copy-fallback" class="copy-fallback" hidden>
                    <label for="product-link">Sao chép liên kết trực tiếp:</label>
                    <input id="product-link" type="text" readonly>
                </div>

                <!-- Attributes Grid (7 fields) -->
                <dl class="attributes">
                    <div class="attribute">
                        <dt>Nhà sản xuất</dt>
                        <dd><?= e($product['producer'] ?? 'Duvin Estates') ?></dd>
                    </div>
                    <div class="attribute">
                        <dt><label for="vintage-select">Niên vụ</label></dt>
                        <dd>
                            <?php if ($product['type'] === 'gift'): ?>
                                <span>Tiêu chuẩn</span>
                            <?php else: ?>
                                <select id="vintage-select" aria-describedby="vintage-help">
                                    <?php foreach ($vintages as $vintage): ?>
                                        <option value="<?= e($vintage['year']) ?>"><?= e($vintage['year']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
                        </dd>
                    </div>
                    <div class="attribute">
                        <dt>Nồng độ cồn</dt>
                        <dd data-vintage="alcohol"><?= e($currentVintage['alcohol']) ?></dd>
                    </div>
                    <div class="attribute">
                        <dt>Giống nho</dt>
                        <dd><?= e($product['grape'] ?? 'Cabernet Sauvignon · Merlot') ?></dd>
                    </div>
                    <div class="attribute">
                        <dt>Phân hạng</dt>
                        <dd data-vintage="classification"><?= e($currentVintage['classification']) ?></dd>
                    </div>
                    <div class="attribute">
                        <dt>Xuất xứ</dt>
                        <dd><?= e($product['origin'] ?? 'Bordeaux, Pháp') ?></dd>
                    </div>
                    <div class="attribute">
                        <dt>Dung tích</dt>
                        <dd>750 ml</dd>
                    </div>
                    <div class="attribute">
                        <dt>Tình trạng</dt>
                        <dd><?= $product['in_stock'] ? 'Còn hàng' : 'Liên hệ' ?></dd>
                    </div>
                </dl>
                <p id="vintage-help" class="sr-only">Thay đổi niên vụ sẽ cập nhật giá, nồng độ, phân hạng và ghi chú hương vị tương ứng.</p>

                <!-- Support & CTA Column -->
                <div class="support-column">
                    <div class="contact row-product-contact">
                        <h2>Liên hệ tư vấn &amp; đặt hàng</h2>
                        <div class="buttons">
                            <a class="button alert is-outline lowercase expand productcontact-phone" href="tel:+84589598386">
                                <span aria-hidden="true">☎</span> 058 959 8386
                            </a>
                            <a class="button alert is-outline lowercase expand productcontact-zalo" href="https://zalo.me/0589598386" target="_blank" rel="noopener noreferrer">
                                Zalo tư vấn ↗
                            </a>
                            <a class="button alert is-outline lowercase expand productcontact-mess wide" href="https://www.facebook.com/messages/t/DuVinVN" target="_blank" rel="noopener noreferrer">
                                Nhắn tin Facebook Messenger ↗
                            </a>
                        </div>
                    </div>

                    <div class="duvin-promises">
                        <h2>Duvin cam kết</h2>
                        <div class="commitments">
                            <?php foreach ($commitments as [$symbol, $title, $description]): ?>
                                <div class="commitment">
                                    <?= $renderIcon($symbol) ?>
                                    <strong><?= e($title) ?></strong>
                                    <p><?= e($description) ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Product Detail & Tasting Notes Section -->
    <section class="section details-section" aria-labelledby="detail-heading">
        <div class="container reading">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">Khám phá từng tầng hương vị</p>
                    <h2 id="detail-heading">Chi tiết sản phẩm</h2>
                </div>
                <span class="vintage-tag">NIÊN VỤ <span data-vintage="year"><?= e($currentVintage['year']) ?></span></span>
            </div>

            <div class="detail-title">
                <h3><?= e($product['name']) ?></h3>
            </div>

            <h3>Giới thiệu tổng quan</h3>
            <p class="body-copy" data-vintage="description"><?= e($currentVintage['description']) ?></p>

            <h3>Tasting Notes (Ghi chú thưởng rượu)</h3>
            <div class="tasting">
                <?php
                $tastingLabels = [
                    'color'  => 'Màu sắc',
                    'aroma'  => 'Mùi hương',
                    'palate' => 'Hương vị',
                    'finish' => 'Hậu vị'
                ];
                $step = 1;
                foreach ($tastingLabels as $key => $label): ?>
                    <div class="taste">
                        <span>0<?= $step++ ?></span>
                        <h4><?= e($label) ?></h4>
                        <p data-vintage="<?= e($key) ?>"><?= e($currentVintage[$key]) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <div id="description-extra" hidden>
                <div class="detail-columns">
                    <div>
                        <h3>Thông số kỹ thuật</h3>
                        <dl class="specs">
                            <div><dt>Tên sản phẩm</dt><dd><?= e($product['name']) ?></dd></div>
                            <div><dt>Loại sản phẩm</dt><dd><?= e($product['category_label'] ?? 'Rượu vang') ?></dd></div>
                            <div><dt>Xuất xứ</dt><dd><?= e($product['origin'] ?? 'Pháp') ?></dd></div>
                            <div><dt>Dung tích</dt><dd>750 ml</dd></div>
                            <div><dt>Niên vụ</dt><dd data-vintage="year"><?= e($currentVintage['year']) ?></dd></div>
                            <div><dt>Nồng độ</dt><dd data-vintage="alcohol"><?= e($currentVintage['alcohol']) ?></dd></div>
                            <div><dt>Phân hạng</dt><dd data-vintage="classification"><?= e($currentVintage['classification']) ?></dd></div>
                        </dl>
                    </div>
                    <div>
                        <div class="editorial-block">
                            <h3>Bảo quản &amp; cách thưởng thức</h3>
                            <p class="body-copy">Bảo quản ở nhiệt độ mát mẻ (12–16°C), độ ẩm ổn định, tránh ánh nắng trực tiếp và rung lắc. Phục vụ ngon nhất ở 16–18°C, mở trước 30–60 phút để vang thở và bung tỏa cấu trúc tốt nhất.</p>
                        </div>
                        <div class="editorial-block">
                            <h3>Dành cho ai?</h3>
                            <p class="body-copy">Thích hợp cho những người yêu thích hương vị vang có chiều sâu, dùng trong những bữa tối sum họp gia đình, tiệc chiêu đãi sang trọng hoặc làm quà biếu đối tác quan trọng.</p>
                        </div>
                    </div>
                </div>

                <h3>Mua rượu vang chính hãng tại DuVin</h3>
                <p class="body-copy">Đội ngũ chuyên gia Duvin luôn đồng hành để mang đến cho bạn trải nghiệm thưởng vang trọn vẹn nhất. Mọi sản phẩm đều được bảo quản trong hầm lạnh chuyên dụng đạt tiêu chuẩn quốc tế.</p>
                <address id="contact-duvin" class="contact-strip" style="font-style:normal">
                    <span>Showroom: 588 Võ Văn Dũng, Đống Đa, Hà Nội</span>
                    <a href="tel:0589598386">Hotline: 058 959 8386</a>
                    <a href="/">Website Duvin ↗</a>
                </address>
            </div>

            <div class="description-toggle-wrap">
                <button id="description-toggle" class="button" type="button" aria-expanded="false" aria-controls="description-extra">
                    Xem thêm chi tiết <span aria-hidden="true">↓</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Expert Reviews Section -->
    <section class="section">
        <div class="container">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">Góc nhìn từ chuyên gia</p>
                    <h2>Đánh giá &amp; Nhận định</h2>
                </div>
                <p>Tham khảo đánh giá từ các hội đồng nếm thử uy tín.</p>
            </div>
            <div class="reviews">
                <?php foreach ($reviews as $review): ?>
                    <article class="review">
                        <div class="score"><?= (int) $review['score'] ?><small>/100 PTS</small></div>
                        <div>
                            <h3><?= e($review['name']) ?></h3>
                            <blockquote>“<?= e($review['quote']) ?>”</blockquote>
                            <span class="mock-label">Hội đồng nếm thử độc lập</span>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section">
        <div class="container faq-wrap">
            <div>
                <p class="eyebrow">Duvin giải đáp</p>
                <h2>Câu hỏi thường gặp</h2>
                <p class="faq-intro">Một số thông tin hữu ích giúp bạn chọn lựa chai vang phù hợp nhất.</p>
            </div>
            <div>
                <?php foreach ($faqs as $index => [$question, $answer]): ?>
                    <details <?= $index === 0 ? 'open' : '' ?>>
                        <summary><?= e(sprintf($question, $product['name'])) ?></summary>
                        <p><?= e($answer) ?></p>
                    </details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Related Products Section -->
    <?php if (!empty($relatedProducts)): ?>
        <section id="related-section" class="section related related-products-wrapper product-section">
            <div class="container">
                <div class="section-heading">
                    <div>
                        <p class="eyebrow">Tiếp nối hành trình khám phá</p>
                        <h2 class="product-section-title-related">Sản phẩm tương tự</h2>
                    </div>
                    <p>Tuyển chọn những sản phẩm cùng bộ sưu tập hoặc phân hạng.</p>
                </div>

                <div id="related-grid" class="row large-columns-4 medium-columns-3 small-columns-2 row-small">
                    <?php foreach ($relatedProducts as $index => $cardProduct): ?>
                        <?php include __DIR__ . '/components/catalog/product-card.php'; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
</main>

<div id="demo-toast" class="toast" role="status" aria-live="polite" aria-atomic="true"></div>
<p id="vintage-announcement" class="sr-only" role="status" aria-live="polite"></p>

<script id="vintages-data" type="application/json"><?= json_encode($vintages, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_THROW_ON_ERROR) ?></script>
<script src="/assets/js/pdp.js" defer></script>
