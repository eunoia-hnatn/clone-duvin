/* ============================================================================
   DUVIN — Homepage JavaScript
   Phase 2: Cleaned, only active code retained.
   Slider, tabs, mobile menu are handled by flatsome.js (Flatsome theme).
   ============================================================================ */

document.addEventListener('DOMContentLoaded', function () {
	initSmoothScroll();
});

/* ============================================================================
   Smooth Scroll — anchor link enhancement
   ============================================================================ */
function initSmoothScroll() {
	document.querySelectorAll('a[href^="#"]').forEach(anchor => {
		anchor.addEventListener('click', function (e) {
			const href = this.getAttribute('href');
			if (!href || href === '#') return;

			let id;
			try {
				id = decodeURIComponent(href.slice(1));
			} catch {
				return;
			}

			const target = document.getElementById(id);
			if (target) {
				e.preventDefault();
				target.scrollIntoView({
					behavior: 'smooth',
					block: 'start'
				});
			}
		});
	});
}
