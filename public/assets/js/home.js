/* Local Phase 1 components. No WordPress, commerce or remote API calls. */
'use strict';
function initSlider(root) {
    if (!root || root.dataset.sliderReady) return;
    const slides = Array.from(root.children).filter(node => node.matches('.row, .col, .banner'));
    if (!slides.length) return;
    root.dataset.sliderReady = 'true';
    const brands = root.classList.contains('home-brandlogo-slider');
    const controls = document.createElement('div');
    controls.className = 'demo-slider-controls';
    controls.setAttribute('aria-label', brands ? 'Thương hiệu' : 'Điều khiển trình chiếu');
    const labels = root.closest('.home-mainslider') ? ['Macallan 84', 'New Arrival', 'Armagnac', 'Wine', 'Japanese Whisky'] : [];
    let current = 0, timer = null, paused = false;
    const perPage = () => brands ? (window.innerWidth >= 850 ? 5 : window.innerWidth >= 550 ? 3 : 1) : 1;
    const pageCount = () => Math.ceil(slides.length / perPage());
    const dots = slides.map((slide, i) => {
        const button = document.createElement('button');
        button.type = 'button'; button.textContent = labels[i] || String(i + 1);
        button.setAttribute('aria-label', 'Xem slide ' + (labels[i] || (i + 1)));
        button.addEventListener('click', () => { show(i); restart(); });
        controls.append(button); return button;
    });
    function show(page) {
        const count = pageCount();
        if (!count) return;
        current = ((page % count) + count) % count;
        slides.forEach((slide, i) => {
            const selected = Math.floor(i / perPage()) === current;
            slide.hidden = !selected; slide.classList.toggle('demo-slide-active', selected);
            slide.setAttribute('aria-hidden', String(!selected));
            // Hidden slides must not receive keyboard focus.
            slide.inert = !selected;
        });
        dots.forEach((dot, i) => { dot.hidden = i >= count; dot.classList.toggle('active', i === current); dot.setAttribute('aria-pressed', String(i === current)); });
    }
    function stop() { if (timer !== null) { clearInterval(timer); timer = null; } }
    function restart() {
        stop();
        if (pageCount() > 1 && !paused && !root.matches(':hover') && !root.contains(document.activeElement) && !document.hidden && !matchMedia('(prefers-reduced-motion: reduce)').matches) timer = setInterval(() => show(current + 1), 5000);
    }
    const pause = document.createElement('button'); pause.type = 'button'; pause.textContent = 'Tạm dừng';
    pause.addEventListener('click', () => { paused = !paused; pause.textContent = paused ? 'Phát' : 'Tạm dừng'; restart(); });
    if (slides.length > 1) { controls.append(pause); root.after(controls); }
    root.classList.add('demo-slider'); show(0); restart();
    root.addEventListener('mouseenter', stop); root.addEventListener('mouseleave', restart);
    root.addEventListener('focusin', stop); root.addEventListener('focusout', () => setTimeout(restart, 0));
    root.addEventListener('keydown', event => {
        if (!['ArrowLeft','ArrowRight'].includes(event.key)) return;
        event.preventDefault(); show(current + (event.key === 'ArrowRight' ? 1 : -1)); restart();
    });
    window.addEventListener('resize', () => { show(Math.min(current, pageCount() - 1)); restart(); });
    document.addEventListener('visibilitychange', restart);
    window.addEventListener('pagehide', stop);
    window.addEventListener('pageshow', restart);
}
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.slider').forEach(initSlider);
    document.querySelectorAll('[data-animate]').forEach(node => node.setAttribute('data-animated', 'true'));
    const menu = document.getElementById('main-menu');
    const toggle = document.querySelector('.demo-menu-toggle');
    toggle?.addEventListener('click', () => { menu.showModal(); toggle.setAttribute('aria-expanded','true'); });
    menu?.addEventListener('close', () => toggle?.setAttribute('aria-expanded','false'));
    document.querySelectorAll('dialog').forEach(dialog => {
        dialog.querySelectorAll('[data-close-dialog]').forEach(button => button.addEventListener('click', () => dialog.close()));
        dialog.addEventListener('click', event => { if (event.target === dialog) { const box = dialog.getBoundingClientRect(); if (event.clientX < box.left || event.clientX > box.right || event.clientY < box.top || event.clientY > box.bottom) dialog.close(); } });
    });
    document.addEventListener('click', event => {
        const target = event.target.closest('[data-demo-contact], [data-demo-pending], a[href="#demo-pending"], a[href="#demo-contact"]');
        if (!target) return;
        event.preventDefault();
        const dialog = document.getElementById(target.matches('[data-demo-contact], [href="#demo-contact"]') ? 'demo-contact' : 'demo-pending');
        if (dialog && !dialog.open) dialog.showModal();
    });
    document.querySelectorAll('.woocommerce-ordering, .woocommerce-ordering-box').forEach(form => {
        const explain = event => { event.preventDefault(); document.getElementById('demo-pending')?.showModal(); };
        form.addEventListener('submit', explain); form.querySelectorAll('select').forEach(select => select.addEventListener('change', explain));
    });
    document.querySelectorAll('[role="tablist"]').forEach(list => {
        const tabs = Array.from(list.querySelectorAll('[role="tab"]'));
        function activate(tab) {
            const cta = list.closest('.tabbed-content')?.querySelector('.choosetype-seemore');
            const destinations = {'tab_scotch-whisky':'/danh-muc/scotch-whisky','tab_japanese-whisky':'/danh-muc/world-whisky/whisky-nhat','tab_world-whisky':'/danh-muc/world-whisky'};
            if (cta) cta.href = destinations[tab.getAttribute('aria-controls')] || '/san-pham';
            tabs.forEach(other => {
                const selected = tab === other;
                other.setAttribute('aria-selected', String(selected)); other.tabIndex = selected ? 0 : -1;
                other.closest('li')?.classList.toggle('active', selected);
                const panel = document.getElementById(other.getAttribute('aria-controls'));
                if (panel) { panel.hidden = !selected; panel.classList.toggle('active', selected); }
            });
        }
        tabs.forEach((tab,i) => {
            tab.addEventListener('click', event => { event.preventDefault(); activate(tab); });
            tab.addEventListener('keydown', event => { if (['ArrowLeft','ArrowRight'].includes(event.key)) { event.preventDefault(); const next = tabs[(i + (event.key === 'ArrowRight' ? 1 : tabs.length - 1)) % tabs.length]; next.focus(); activate(next); } });
        });
        if (tabs.length) activate(tabs[0]);
    });
});
