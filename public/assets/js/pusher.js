/**
 * Pusher – Scroll-to-top & Nút liên hệ nhanh
 * Vanilla JS, không phụ thuộc thư viện.
 */
(function () {
    'use strict';

    /* ─── Hằng số layout ─── */
    var CONTACT_BOTTOM   = 28;   // bottom của .pusher-widget (px)
    var CONTACT_HEIGHT   = 58;   // height của .pusher-toggle (px)
    var GAP_DEFAULT      = 12;   // khoảng cách mặc định giữa 2 nút (px)
    var OPTION_HEIGHT    = 46;   // height mỗi nút option (px)
    var OPTION_GAP       = 10;   // gap giữa các option (px)
    var OPTION_COUNT     = 3;    // số lượng nút option
    var OPTIONS_GAP      = 10;   // gap giữa options-list và toggle (px)

    /* Mobile breakpoint */
    var MOBILE_BP = 549;

    function isMobile() {
        return window.innerWidth <= MOBILE_BP;
    }

    /* Tính bottom mặc định của scroll-top (ngay sát trên toggle) */
    function getDefaultBottom() {
        if (isMobile()) {
            return 20 + 52 + 10; /* mobile: bottom 20, height 52, gap 10 */
        }
        return CONTACT_BOTTOM + CONTACT_HEIGHT + GAP_DEFAULT;
    }

    /* Tính bottom khi menu mở:
     * Toggle + gap + (OPTION_HEIGHT + OPTION_GAP) × 3 − OPTION_GAP cuối + GAP_DEFAULT
     * = vị trí mặc định + chiều cao toàn bộ options panel */
    function getOpenBottom() {
        var optionPanelHeight = OPTION_COUNT * OPTION_HEIGHT
                              + (OPTION_COUNT - 1) * OPTION_GAP
                              + OPTIONS_GAP;
        return getDefaultBottom() + optionPanelHeight;
    }

    document.addEventListener('DOMContentLoaded', function () {

        var scrollBtn = document.getElementById('scrollToTop');
        var widget    = document.getElementById('pusher-widget');
        var toggle    = document.getElementById('pusherToggle');
        var options   = document.getElementById('pusherOptions');

        /* ── Khởi tạo bottom ban đầu cho scroll-top ── */
        if (scrollBtn) {
            scrollBtn.style.bottom = getDefaultBottom() + 'px';
        }

        /* Cập nhật lại khi resize */
        window.addEventListener('resize', function () {
            if (scrollBtn && widget && !widget.classList.contains('is-open')) {
                scrollBtn.style.bottom = getDefaultBottom() + 'px';
            }
        }, { passive: true });

        /* ── Scroll-to-top: hiện / ẩn ── */
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

        /* ── Nút liên hệ toggle ── */
        if (!widget || !toggle || !options) return;

        function openWidget() {
            widget.classList.add('is-open');
            toggle.setAttribute('aria-expanded', 'true');
            options.setAttribute('aria-hidden', 'false');

            /* Đẩy scroll-top lên trên các option */
            if (scrollBtn) {
                scrollBtn.style.bottom = getOpenBottom() + 'px';
                scrollBtn.style.zIndex = '9999';
            }
        }

        function closeWidget() {
            widget.classList.remove('is-open');
            toggle.setAttribute('aria-expanded', 'false');
            options.setAttribute('aria-hidden', 'true');

            /* Trả scroll-top về vị trí mặc định */
            if (scrollBtn) {
                scrollBtn.style.bottom = getDefaultBottom() + 'px';
                scrollBtn.style.zIndex = '';
            }
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
