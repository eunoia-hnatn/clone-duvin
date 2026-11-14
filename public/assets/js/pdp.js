/**
 * Duvin Product Detail Page (PDP) Interactions
 * Xử lý đổi niên vụ (Vintage Selector), đóng/mở chi tiết và sao chép link chia sẻ.
 */
(() => {
    'use strict';
    const dataEl = document.getElementById('vintages-data');
    let vintages = [];
    if (dataEl) {
        try {
            vintages = JSON.parse(dataEl.textContent || '[]');
        } catch (e) {
            console.error('Failed to parse vintages JSON data:', e);
        }
    }
    const root = document.getElementById('product-detail-view');
    const select = document.getElementById('vintage-select');
    const toast = document.getElementById('demo-toast');
    let toastTimer;

    const showToast = message => {
        if (!toast) return;
        clearTimeout(toastTimer);
        toast.textContent = message;
        toastTimer = setTimeout(() => { toast.textContent = ''; }, 3500);
    };

    // Toggle description expansion
    const descriptionExtra = document.getElementById('description-extra');
    const descriptionToggle = document.getElementById('description-toggle');
    if (descriptionExtra && descriptionToggle) {
        descriptionToggle.addEventListener('click', () => {
            const expanded = descriptionToggle.getAttribute('aria-expanded') !== 'true';
            descriptionExtra.hidden = !expanded;
            descriptionToggle.setAttribute('aria-expanded', String(expanded));
            descriptionToggle.innerHTML = expanded ? 'Thu gọn <span aria-hidden="true">↑</span>' : 'Xem thêm chi tiết <span aria-hidden="true">↓</span>';
            if (!expanded) {
                descriptionToggle.scrollIntoView({ block: 'nearest', behavior: 'auto' });
            }
        });
    }

    // Vintage selector event handler
    const formatPrice = value => new Intl.NumberFormat('vi-VN').format(value) + '₫';
    if (root && select) {
        select.addEventListener('change', () => {
            const vintage = vintages.find(item => item.year === select.value);
            if (!vintage) return;
            root.querySelectorAll('[data-vintage]').forEach(element => {
                const key = element.dataset.vintage;
                if (Object.prototype.hasOwnProperty.call(vintage, key)) {
                    element.textContent = key === 'price' ? formatPrice(vintage[key]) : vintage[key];
                }
            });
            const announcement = document.getElementById('vintage-announcement');
            if (announcement) {
                announcement.textContent = `Đã chọn niên vụ ${vintage.year}. Giá ${formatPrice(vintage.price)}. Thông tin hương vị đã được cập nhật.`;
            }
        });
    }

    // Share button handler
    const shareButton = document.getElementById('share-product');
    if (shareButton) {
        shareButton.addEventListener('click', async () => {
            const url = window.location.href;
            let copied = false;
            if (navigator.clipboard && window.isSecureContext) {
                try {
                    await navigator.clipboard.writeText(url);
                    copied = true;
                } catch (err) {}
            }
            if (!copied) {
                const field = document.createElement('textarea');
                field.value = url;
                field.setAttribute('aria-label', 'Liên kết sản phẩm');
                field.style.cssText = 'position:fixed;left:-9999px;top:0';
                document.body.appendChild(field);
                field.select();
                try {
                    copied = document.execCommand('copy');
                } catch (err) {
                    copied = false;
                }
                field.remove();
                shareButton.focus();
            }
            const fallback = document.getElementById('copy-fallback');
            const input = document.getElementById('product-link');
            if (copied) {
                if (fallback) fallback.hidden = true;
                showToast('Đã sao chép liên kết sản phẩm vào bộ nhớ tạm!');
            } else {
                if (fallback && input) {
                    fallback.hidden = false;
                    input.value = url;
                    input.focus();
                    input.select();
                }
                showToast('Vui lòng sao chép liên kết hiển thị bên dưới giá.');
            }
        });
    }
})();

