# Chạy ứng dụng Duvin

Yêu cầu PHP 8.0 trở lên. Chưa cần database hoặc Composer cho Phần 1–2.

Cách chạy khuyến nghị, từ thư mục gốc repository:

```sh
php -S 127.0.0.1:8000 -t public public/index.php
```

Mở http://127.0.0.1:8000. Document root là `public/`; assets dùng `/assets/...`.

Entry point cũ vẫn hoạt động với:

```sh
php -S 127.0.0.1:8000 index.php
```

Với Apache, bật mod_rewrite và cho phép `.htaccess` (AllowOverride phù hợp). Ưu tiên VirtualHost trỏ tới `public/`. `.htaccess` tại gốc hỗ trợ triển khai cũ, chuyển `/assets/` vào `public/assets/` và chặn truy cập các thư mục mã ứng dụng. Nếu dùng Nginx, cấu hình document root tới `public/` và fallback request không có file về `index.php`; Nginx không đọc `.htaccess`. Ứng dụng hiện giả định được host tại `/`.

## Core

`bootstrap/app.php` nạp các lớp hiện tại. `routes/web.php` khai báo route. `Router::get()` và `Router::post()` nhận callable; placeholder có thể có regex constraint. Route cụ thể cần đứng trước route động. Router trả 404 khi không có đường dẫn phù hợp, 405 kèm Allow khi có đường dẫn nhưng sai HTTP method. HEAD dùng route GET và Front Controller bỏ body. Chưa đăng ký POST nghiệp vụ vì chưa có backend tương ứng.

`BaseController::render()` nhận tên View và mảng dữ liệu, chỉ cho phép template bên trong `app/views`. Controllers hiện dùng render; mock data is loaded through Repositories; see docs/fixtures.md. Các action trỏ tới quiz/engraving đã xóa được gỡ khỏi PageController.

URL `/ve-duvin` thay `/ve-dangtau-whisky`; route cũ chuyển hướng 301. `/product-category/...` chuyển hướng sang `/danh-muc/...`, giữ query string. Các URL bài viết chưa có route chi tiết sẽ trả 404; không tự chuyển mọi bài viết về một trang khác.

## Giới hạn đang chờ Phase 2

URL WordPress cũ được chuyển nội bộ; `/wp-json/`, `/wp-comments-post.php` và `/wp-admin/admin-ajax.php` chưa có backend. Chuyển URL không tạo chức năng lưu đánh giá, tìm kiếm hoặc đăng nhập. Các cấu hình AJAX trỏ `/404` và các thư viện giao diện cũ chưa được thay trong phạm vi này.

Bốn asset thiếu từ trước vẫn cần xử lý riêng: toastr.min.css, toastr.min.js, api.js, powered-by-servisense-dark.svg. Đường dẫn Open Graph cũ được thay bằng logo Duvin local vì không có file thumbnail cũ. robots.txt chưa khai báo Sitemap cho tới khi có domain triển khai và sitemap thực tế.

Kiểm tra Core:

```sh
php tests/core.php
php tests/fixtures.php
php tests/article-links.php
node tests/home-js.cjs
```

## Link cleanup

Article listing uses fixture pagination (3 items per page), and existing /blog/{slug} URLs render matching title/image plus an explicit unfinished-content notice. Unknown articles/pages remain 404. Password recovery has a read-only help page; it does not submit or send reset emails. Legacy /san-pham/page/2 redirects to /san-pham while preserving its query; product filtering/search logic is unchanged. home.js skips absent/custom components and Flickity-managed sliders.
