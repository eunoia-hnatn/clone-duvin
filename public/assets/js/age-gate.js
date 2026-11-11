/**
 * Age Gate 18+ — Cookie & Display Logic
 *
 * - Kiểm tra cookie `duvin_age_verified` khi tải trang.
 * - Chưa có cookie → hiển thị modal, làm mờ nội dung trang.
 * - "Tôi đủ 18 tuổi" → set cookie (15 phút), ẩn modal, khôi phục nội dung.
 * - "Tôi chưa đủ 18 tuổi" → hiện thông báo chặn, giữ nội dung bị mờ.
 */
(function () {
    'use strict';

    var COOKIE_NAME = 'duvin_age_verified';
    var overlay = document.getElementById('age-gate-overlay');

    // Không có overlay hoặc age gate bị tắt → thoát
    if (!overlay) return;

    // Đọc số phút lưu cookie từ data attribute (default 15)
    var cookieMinutes = parseInt(overlay.getAttribute('data-cookie-minutes'), 10) || 15;

    /**
     * Đọc giá trị cookie theo tên.
     */
    function getCookie(name) {
        var match = document.cookie.match('(?:^|; )' + name + '=([^;]*)');
        return match ? decodeURIComponent(match[1]) : null;
    }

    /**
     * Ghi cookie với thời hạn tính bằng phút.
     */
    function setCookie(name, value, minutes) {
        var expires = new Date(Date.now() + minutes * 60 * 1000).toUTCString();
        document.cookie = name + '=' + encodeURIComponent(value) +
            '; expires=' + expires +
            '; path=/' +
            '; SameSite=Lax';
    }

    /**
     * Hiện modal và khoá cuộn trang.
     */
    function showModal() {
        overlay.classList.add('is-active');
        document.body.style.overflow = 'hidden';
        // Làm mờ nội dung trang (giữ header/footer mờ nhẹ để nhận biết còn trang web)
        var wrapper = document.getElementById('wrapper');
        if (wrapper) {
            wrapper.style.filter = 'blur(8px)';
            wrapper.style.pointerEvents = 'none';
        }
    }

    /**
     * Ẩn modal và khôi phục trang.
     */
    function hideModal() {
        overlay.classList.remove('is-active');
        document.body.style.overflow = '';
        var wrapper = document.getElementById('wrapper');
        if (wrapper) {
            wrapper.style.filter = '';
            wrapper.style.pointerEvents = '';
        }
    }

    /**
     * Hiện thông báo "chưa đủ tuổi" và ẩn các nút.
     */
    function showDenied() {
        var denied = document.getElementById('age-gate-denied');
        var buttons = document.querySelector('.age-gate-buttons');
        var message = document.querySelector('.age-gate-message');
        var title = document.querySelector('.age-gate-title');

        if (denied) denied.style.display = 'block';
        if (buttons) buttons.style.display = 'none';
        if (message) message.style.display = 'none';
        if (title) title.textContent = 'Truy cập bị từ chối';
    }

    // Khởi tạo khi DOM sẵn sàng
    document.addEventListener('DOMContentLoaded', function () {
        // Đã xác nhận → thoát luôn
        if (getCookie(COOKIE_NAME) === '1') {
            return;
        }

        // Hiện modal
        showModal();

        // Nút "Đủ 18 tuổi"
        var confirmBtn = document.getElementById('age-gate-confirm');
        if (confirmBtn) {
            confirmBtn.addEventListener('click', function () {
                setCookie(COOKIE_NAME, '1', cookieMinutes);
                hideModal();
            });
        }

        // Nút "Chưa đủ 18 tuổi"
        var denyBtn = document.getElementById('age-gate-deny');
        if (denyBtn) {
            denyBtn.addEventListener('click', function () {
                showDenied();
            });
        }
    });
})();
