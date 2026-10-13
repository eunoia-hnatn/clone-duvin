<!-- Pusher: Nút Scroll-to-top (độc lập) -->
<button id="scrollToTop"
        class="pusher-scroll-top"
        aria-label="Lên đầu trang"
        title="Lên đầu trang">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
         stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
         width="26" height="26">
        <polyline points="18 15 12 9 6 15"/>
    </svg>
</button>

<!-- Pusher: Nút liên hệ nhanh (độc lập) -->
<div id="pusher-widget" class="pusher-widget" aria-label="Liên hệ nhanh">

    <!-- Các nút liên hệ (hiện khi mở) -->
    <div class="pusher-options" id="pusherOptions" aria-hidden="true">

        <a href="tel:+84589598386"
           class="pusher-option pusher-option--phone"
           aria-label="Gọi điện"
           title="Gọi: (+84) 58 959 8386">
            <span class="pusher-option__icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="22" height="22">
                    <path d="M6.62 10.79a15.53 15.53 0 006.59 6.59l2.2-2.2a1 1 0 011.11-.21 11.36 11.36 0 003.55.57 1 1 0 011 1V21a1 1 0 01-1 1A17 17 0 013 5a1 1 0 011-1h3.5a1 1 0 011 1 11.36 11.36 0 00.57 3.55 1 1 0 01-.21 1.11z"/>
                </svg>
            </span>
            <span class="pusher-option__label">Gọi điện</span>
        </a>

        <a href="https://zalo.me/0589598386"
           class="pusher-option pusher-option--zalo"
           target="_blank" rel="noopener noreferrer"
           aria-label="Zalo"
           title="Nhắn Zalo">
            <span class="pusher-option__icon">
                <img src="/public/assets/images/zalo1-icon.png" alt="Zalo" width="22" height="22" />
            </span>
            <span class="pusher-option__label">Zalo</span>
        </a>

        <a href="https://www.facebook.com/DuVinVN/"
           class="pusher-option pusher-option--facebook"
           target="_blank" rel="noopener noreferrer"
           aria-label="Facebook"
           title="Nhắn Facebook">
            <span class="pusher-option__icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="22" height="22">
                    <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
                </svg>
            </span>
            <span class="pusher-option__label">Facebook</span>
        </a>

    </div>

    <!-- Nút chính toggle -->
    <button id="pusherToggle"
            class="pusher-toggle"
            aria-expanded="false"
            aria-controls="pusherOptions"
            aria-label="Mở liên hệ nhanh">
        <span class="pusher-toggle__icon pusher-toggle__icon--open">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="26" height="26">
                <path d="M20 2H4a2 2 0 00-2 2v18l4-4h14a2 2 0 002-2V4a2 2 0 00-2-2zm-2 10H6v-2h12zm0-3H6V7h12z"/>
            </svg>
        </span>
        <span class="pusher-toggle__icon pusher-toggle__icon--close">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                 width="22" height="22">
                <line x1="18" y1="6" x2="6" y2="18"/>
                <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </span>
    </button>

</div>
