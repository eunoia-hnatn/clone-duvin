/**
 * Age Gate 18+ — Cookie & Display Logic
 *
 * - Trang /under-18: tự động chuyển về '/' khi hết thời gian chờ (30 phút).
 * - Trang nội dung: kiểm tra cookie `duvin_age_verified`.
 *   + Chưa có cookie → hiển thị modal overlay ngay trên URL hiện tại, làm mờ nền.
 *   + "Tôi đủ 18 tuổi" → set cookie 7 ngày (10080 phút), ẩn modal, giữ nguyên trang.
 *   + "Tôi chưa đủ 18 tuổi" → submit POST /age-verify để server set cookie chặn 30 phút và chuyển /under-18.
 */
(function () {
    'use strict';

    var COOKIE_NAME = 'duvin_age_verified';

    // 1. Xử lý trang /under-18: tự động đưa về URL gốc sau khi hết 30 phút
    var under18Body = document.querySelector('body[data-under18-remaining]');
    if (under18Body) {
        var remainingSeconds = parseInt(under18Body.getAttribute('data-under18-remaining'), 10);
        if (remainingSeconds > 0) {
            window.setTimeout(function () {
                window.location.href = '/';
            }, remainingSeconds * 1000);
        }
        return;
    }

    var overlay = document.getElementById('age-gate-overlay');

    // Không có overlay hoặc age gate bị tắt → thoát
    if (!overlay) return;

    // Đọc số phút lưu cookie từ data attribute (default 7 ngày = 10080 phút)
    var cookieMinutes = parseInt(overlay.getAttribute('data-cookie-minutes'), 10) || 10080;

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
    });
})();
