<?php require VIEW_PATH . '/layouts/header.php'; ?>
<div class="container demo-notice">Giao diện minh họa — dữ liệu chi tiết sản phẩm theo đường dẫn đang chờ chặng 2. Thông tin bên dưới chưa phải dữ liệu được xác nhận.</div>


    <!-- Breadcrumb -->
    <section class="breadcrumb-section">
        <div class="container">
            <p class="breadcrumb">
                <a href="/">Trang Chủ</a> / 
                <a href="/san-pham">Sản Phẩm</a> / 
                <span>Macallan 18 Sherry Oak</span>
            </p>
        </div>
    </section>

    <!-- Product Detail -->
    <section class="product-detail">
        <div class="container">
            <div class="product-detail-wrapper">
                <!-- Product Images -->
                <div class="product-gallery">
                    <div class="main-image">
                        <img src="https://via.placeholder.com/500x600?text=Product+Image" alt="Macallan 18 Sherry Oak" id="mainImage">
                    </div>
                    <div class="thumbnail-images">
                        <img src="https://via.placeholder.com/80x100?text=Thumb+1" alt="Thumbnail 1" class="thumbnail" data-demo-pending>
                        <img src="https://via.placeholder.com/80x100?text=Thumb+2" alt="Thumbnail 2" class="thumbnail" data-demo-pending>
                        <img src="https://via.placeholder.com/80x100?text=Thumb+3" alt="Thumbnail 3" class="thumbnail" data-demo-pending>
                        <img src="https://via.placeholder.com/80x100?text=Thumb+4" alt="Thumbnail 4" class="thumbnail" data-demo-pending>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="product-info">
                    <div class="product-title-section">
                        <h1>Macallan 18 Sherry Oak</h1>
                        <p class="product-category">
                            <a href="/san-pham">Scotch Whisky</a>
                        </p>
                    </div>

                    <div class="product-rating">
                        <span class="stars">★★★★★</span>
                        <span class="rating-text">(12 đánh giá)</span>
                    </div>

                    <div class="product-price-section">
                        <p class="price">2.850.000 đ</p>
                        <p class="availability in-stock">
                            ✓ Còn hàng
                        </p>
                    </div>

                    <div class="product-specifications">
                        <h3>Thông Số Kỹ Thuật</h3>
                        <table>
                            <tr>
                                <td class="spec-label">Xuất Xứ:</td>
                                <td class="spec-value">Scotland</td>
                            </tr>
                            <tr>
                                <td class="spec-label">Vùng:</td>
                                <td class="spec-value">Speyside</td>
                            </tr>
                            <tr>
                                <td class="spec-label">Độ Cồn:</td>
                                <td class="spec-value">43%</td>
                            </tr>
                            <tr>
                                <td class="spec-label">Dung Tích:</td>
                                <td class="spec-value">700ml</td>
                            </tr>
                            <tr>
                                <td class="spec-label">Tuổi:</td>
                                <td class="spec-value">18 Năm</td>
                            </tr>
                            <tr>
                                <td class="spec-label">Loại Thùng:</td>
                                <td class="spec-value">Sherry Oak</td>
                            </tr>
                        </table>
                    </div>

                    <div class="product-quantity">
                        <label for="quantity">Số Lượng:</label>
                        <div class="quantity-selector">
                            <button class="qty-btn minus" data-demo-pending>−</button>
                            <input type="number" id="quantity" value="1" min="1">
                            <button class="qty-btn plus" data-demo-pending>+</button>
                        </div>
                    </div>

                    <div class="product-actions">
                        <button class="btn btn-primary" data-demo-contact>Tư vấn</button>
                        <button class="btn btn-secondary" data-demo-pending>♡ Yêu Thích</button>
                    </div>

                    <div class="product-shipping">
                        <h3>Thông Tin Giao Hàng</h3>
                        <ul>
                            <li>📦 Giao hàng toàn quốc (2-3 ngày làm việc)</li>
                            <li>🔒 Đóng gói an toàn, không bị vỡ</li>
                            <li>🔄 Chính sách hoàn trả 30 ngày</li>
                            <li>✓ 100% sản phẩm chính hãng</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Description & Tabs -->
    <section class="product-tabs">
        <div class="container">
            <div class="tabs-header">
                <button class="tab-button active" data-demo-pending>Mô Tả</button>
                <button class="tab-button" data-demo-pending>Thông Tin Bổ Sung</button>
                <button class="tab-button" data-demo-pending>Đánh Giá (12)</button>
            </div>

            <div class="tabs-content">
                <div class="tab-pane active">
                    <h3>Mô Tả Sản Phẩm</h3>
                    <p>
                        Macallan 18 Sherry Oak là một trong những dòng whisky đơn lẻ tuyệt vời từ Speyside, Scotland. 
                        Nó được lên men trong các thùng sherry chọn lựa đặc biệt, tạo ra một cấu trúc phong phú và một 
                        sự hoàn thiện tuyệt vời.
                    </p>
                    <p>
                        Với 18 năm tuổi, Macallan 18 là một ví dụ hoàn hảo về sự chuyên dụng của nhà máy đối với chất lượng 
                        và cân bằng. Nó có mục tiêu được độc lập duy nhất, một đặc điểm xác định của Macallan, một khía cạnh 
                        được tìm kiếm sau bởi những người đam mê whisky trên toàn thế giới.
                    </p>
                    <p>
                        Hương vị: Tính phức tạp và sự thanh lịch, với gợi ý của trái cây quả nhân tạo và vani, kết hợp với 
                        những ghi chú của spice ấm áp.
                    </p>
                </div>

                <div class="tab-pane">
                    <h3>Thông Tin Bổ Sung</h3>
                    <table class="info-table">
                        <tr>
                            <th>Thuộc Tính</th>
                            <th>Giá Trị</th>
                        </tr>
                        <tr>
                            <td>Thương Hiệu</td>
                            <td>Macallan</td>
                        </tr>
                        <tr>
                            <td>Xuất Xứ</td>
                            <td>Scotland</td>
                        </tr>
                        <tr>
                            <td>Vùng</td>
                            <td>Speyside</td>
                        </tr>
                        <tr>
                            <td>Độ Cồn</td>
                            <td>43%</td>
                        </tr>
                        <tr>
                            <td>Tuổi</td>
                            <td>18 Năm</td>
                        </tr>
                    </table>
                </div>

                <div class="tab-pane">
                    <h3>Đánh Giá Khách Hàng</h3>
                    <div class="reviews">
                        <div class="review">
                            <p class="reviewer-name">Nguyễn Văn A</p>
                            <p class="review-date">5 ⭐ - 15 ngày trước</p>
                            <p class="review-text">Sản phẩm tuyệt vời, chất lượng cao. Giao hàng nhanh và đóng gói chắc chắn. Rất hài lòng!</p>
                        </div>
                        <div class="review">
                            <p class="reviewer-name">Trần Thị B</p>
                            <p class="review-date">5 ⭐ - 20 ngày trước</p>
                            <p class="review-text">Một trong những dòng whisky tốt nhất mà tôi đã uống. Hương vị tuyệt vời, giá cả hợp lý.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    <section class="related-products">
        <div class="container">
            <h2>Sản Phẩm Liên Quan</h2>
            <div class="products-grid">
                <div class="product-card">
                    <img src="https://via.placeholder.com/200x250?text=Related+1" alt="Related Product 1">
                    <h4><a href="/">Balvenie 21 Portwood</a></h4>
                    <p class="price">3.200.000 đ</p>
                </div>
                <div class="product-card">
                    <img src="https://via.placeholder.com/200x250?text=Related+2" alt="Related Product 2">
                    <h4><a href="/">Dalmore 15 King Alexander</a></h4>
                    <p class="price">1.950.000 đ</p>
                </div>
                <div class="product-card">
                    <img src="https://via.placeholder.com/200x250?text=Related+3" alt="Related Product 3">
                    <h4><a href="/">Highland Park 18</a></h4>
                    <p class="price">2.100.000 đ</p>
                </div>
                <div class="product-card">
                    <img src="https://via.placeholder.com/200x250?text=Related+4" alt="Related Product 4">
                    <h4><a href="/">Glenmorangie Signet</a></h4>
                    <p class="price">5.500.000 đ</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->

<?php require VIEW_PATH . '/layouts/footer.php'; ?>
