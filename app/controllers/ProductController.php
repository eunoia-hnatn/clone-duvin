<?php
/**
 * ProductController
 * Xử lý các trang liên quan đến sản phẩm và danh mục
 */
class ProductController
{
    /**
     * Danh sách tất cả sản phẩm — GET /san-pham
     */
    public function index(): void
    {
        $pageTitle    = 'Sản Phẩm | DangTau Whisky';
        $mockCategory = [
            'title' => 'TẤT CẢ SẢN PHẨM',
            'desc'  => 'Khám phá toàn bộ bộ sưu tập whisky và spirits cao cấp được tuyển chọn kỹ lưỡng bởi DangTau Whisky.',
            'slug'  => '',
        ];

        // TODO: $products = ProductModel::getAll();
        $products = [];

        require VIEW_PATH . '/products.php';
    }

    /**
     * Chi tiết sản phẩm — GET /san-pham/{slug}
     */
    public function show(string $slug): void
    {
        $pageTitle  = 'Chi Tiết Sản Phẩm | DangTau Whisky';
        $body_class = 'single-product woocommerce woocommerce-page';

        // TODO: $product = ProductModel::findBySlug($slug);
        $product = null;
        $slug    = htmlspecialchars($slug, ENT_QUOTES, 'UTF-8');

        require VIEW_PATH . '/product-detail.php';
    }

    /**
     * Danh mục sản phẩm — GET /danh-muc/{slug}
     * Hỗ trợ sub-category: /danh-muc/scotch-whisky/whisky-islay
     */
    public function category(string $slug): void
    {
        // Bóc tách slug — hỗ trợ nested (scotch-whisky/whisky-islay)
        $segments = array_values(array_filter(explode('/', $slug)));
        $mainSlug = $segments[0] ?? '';
        $subSlug  = $segments[1] ?? null;

        // ── Mock data — thay thế DB tạm thời ────────────────────────────────
        $categoryMap = [
            'old-rare' => [
                'title' => 'OLD & RARE',
                'desc'  => 'Old & Rare là dòng whisky "cổ và hiếm", thường là những chai single malt được tuyển chọn từ các nhà máy chưng cất danh tiếng, được ủ trong thời gian dài, đôi khi lên đến vài chục năm. Chúng mang đến những trải nghiệm hương vị độc đáo, phức hợp, thể hiện sự tinh túy của thời gian và kỹ thuật ủ rượu bậc thầy.',
            ],
            'armagnac' => [
                'title' => 'ARMAGNAC',
                'desc'  => 'Bộ sưu tập rượu Armagnac thượng hạng — loại rượu brandy lâu đời nhất nước Pháp với lịch sử hơn 700 năm, đến từ vùng Gascony. Mỗi chai Armagnac là kết tinh của thời gian, văn hóa và nghệ thuật chưng cất truyền thống.',
            ],
            'wine' => [
                'title' => 'WINE',
                'desc'  => 'Rượu Vang cao cấp nhập khẩu được tuyển chọn từ những vùng trồng nho danh tiếng nhất thế giới. Từ Burgundy, Bordeaux đến Tuscany — mỗi chai vang là một tác phẩm nghệ thuật kể câu chuyện về đất đai và con người.',
            ],
            'scotch-whisky' => [
                'title' => 'SCOTCH WHISKY',
                'desc'  => 'Scotch Whisky — linh hồn của Scotland. Bộ sưu tập đa dạng từ các vùng Speyside, Highland, Islay, Campbeltown và Lowland, bao gồm cả Single Malt lẫn Blended Scotch từ những nhà máy chưng cất huyền thoại.',
            ],
            'whisky-highland' => [
                'title' => 'HIGHLAND WHISKY',
                'desc'  => 'Highland là vùng sản xuất whisky lớn nhất Scotland với phong cách đa dạng — từ mềm mại và fruity đến đậm đà và peaty. Những chai Highland tiêu biểu mang đặc trưng của vùng núi non hùng vĩ.',
            ],
            'whisky-islay' => [
                'title' => 'ISLAY WHISKY',
                'desc'  => 'Islay — hòn đảo của khói và biển. Whisky Islay nổi tiếng với hương peaty mạnh mẽ, muối biển và iodine đặc trưng. Ardbeg, Laphroaig, Bowmore và những cái tên huyền thoại đến từ hòn đảo nhỏ bé nhưng vĩ đại này.',
            ],
            'whisky-speyside' => [
                'title' => 'SPEYSIDE WHISKY',
                'desc'  => 'Speyside — vùng đất vàng của Scotch Whisky với mật độ nhà máy chưng cất cao nhất Scotland. Đặc trưng bởi hương trái cây ngọt ngào, vani và sherry. Nơi sinh ra những huyền thoại như Macallan, Glenfiddich và Balvenie.',
            ],
            'whisky-nhat' => [
                'title' => 'WHISKY NHẬT BẢN',
                'desc'  => 'Japanese Whisky — sự hoàn hảo của triết học Nhật Bản ứng dụng vào nghệ thuật chưng cất. Tinh tế, cân bằng và phức hợp. Từ những thương hiệu kinh điển như Yamazaki, Hibiki đến thế hệ mới nổi bật như Kanosuke và Chichibu.',
            ],
            'cognac' => [
                'title' => 'COGNAC',
                'desc'  => 'Cognac — rượu brandy danh tiếng nhất thế giới, được chưng cất từ nho Ugni Blanc tại vùng Cognac, Pháp. Từ VS, VSOP đến XO và Extra Old — mỗi cấp độ là một hành trình thời gian khác nhau.',
            ],
            'signatory-vintage' => [
                'title' => 'SIGNATORY VINTAGE',
                'desc'  => 'Signatory Vintage — nhà đóng chai độc lập uy tín với hơn 30 năm lịch sử. Chuyên tuyển chọn và đóng chai những cask whisky quý hiếm từ các nhà máy chưng cất Scotland, mang đến những phiên bản độc quyền không thể tìm thấy ở nơi khác.',
            ],
            'bo-qua-tang' => [
                'title' => 'BỘ QUÀ TẶNG',
                'desc'  => 'Những bộ quà tặng whisky cao cấp được tuyển chọn và đóng gói tinh tế — lựa chọn hoàn hảo cho những dịp đặc biệt. Từ sinh nhật, kỷ niệm đến quà tặng doanh nghiệp sang trọng.',
            ],
            'set-thu-ruou' => [
                'title' => 'SET THỬ RƯỢU',
                'desc'  => 'Bộ set thử rượu được thiết kế dành cho những người mới khám phá thế giới whisky hoặc muốn mở rộng trải nghiệm. Mỗi set là một hành trình khám phá hương vị được curate bởi chuyên gia của DangTau.',
            ],
        ];

        // Kiểm tra sub-slug trước, rồi main-slug
        $lookupKey    = $subSlug ?? $mainSlug;
        $mockCategory = $categoryMap[$lookupKey]
            ?? $categoryMap[$mainSlug]
            ?? [
                'title' => strtoupper(str_replace('-', ' ', $mainSlug)),
                'desc'  => 'Khám phá bộ sưu tập ' . ucwords(str_replace('-', ' ', $mainSlug)) . ' được tuyển chọn kỹ lưỡng bởi DangTau Whisky.',
            ];

        // Gắn thêm slug để View dùng nếu cần
        $mockCategory['slug'] = $slug;

        // Cập nhật page title theo category
        $pageTitle = $mockCategory['title'] . ' | DangTau Whisky';

        // TODO: $products = ProductModel::getByCategory($mainSlug, $subSlug);
        $products = [];

        require VIEW_PATH . '/products.php';
    }
}
