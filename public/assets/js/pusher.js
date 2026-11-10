/**
 * Pusher – Scroll-to-top & Nút liên hệ nhanh
 * Vanilla JS, không phụ thuộc thư viện.
 *
 * Nút scroll-to-top hoàn toàn độc lập với menu liên hệ:
 *   - Vị trí cố định (xem pusher.css), không di chuyển khi menu mở/đóng.
 *   - Hiện/ẩn chỉ dựa vào vị trí cuộn (window scroll), không phụ thuộc menu.
 */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {

        var scrollBtn = document.getElementById('scrollToTop');
        var widget    = document.getElementById('pusher-widget');
        var toggle    = document.getElementById('pusherToggle');
        var options   = document.getElementById('pusherOptions');

        /* ── Scroll-to-top: hiện / ẩn dựa trên vị trí cuộn ── */
        if (scrollBtn) {
            function updateScrollBtn() {
                if (window.pageYOffset > 300) {
                    scrollBtn.classList.add('is-visible');
                } else {
                    scrollBtn.classList.remove('is-visible');
                }
            }

            window.addEventListener('scroll', updateScrollBtn, { passive: true });
            updateScrollBtn();

            scrollBtn.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        /* ── Nút liên hệ toggle (độc lập với scroll-top) ── */
        if (!widget || !toggle || !options) return;

        function openWidget() {
            widget.classList.add('is-open');
            toggle.setAttribute('aria-expanded', 'true');
            options.setAttribute('aria-hidden', 'false');
        }

        function closeWidget() {
            widget.classList.remove('is-open');
            toggle.setAttribute('aria-expanded', 'false');
            options.setAttribute('aria-hidden', 'true');
        }

        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            widget.classList.contains('is-open') ? closeWidget() : openWidget();
        });

        /* Đóng khi click ra ngoài */
        document.addEventListener('click', function (e) {
            if (widget.classList.contains('is-open') && !widget.contains(e.target)) {
                closeWidget();
            }
        });

        /* Đóng khi nhấn Escape */
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && widget.classList.contains('is-open')) {
                closeWidget();
                toggle.focus();
            }
        });
    });
})();
