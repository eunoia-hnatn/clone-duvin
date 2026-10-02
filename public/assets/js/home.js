/* ============================================================================
   DangTau Whisky - Homepage JavaScript
   Interactive features: slider, tabs, mobile menu, etc.
   ============================================================================ */

document.addEventListener('DOMContentLoaded', function() {
	// Initialize all components
	initSlider();
	initTabs();
	initMobileMenu();
	initSmoothScroll();
});

/* ============================================================================
   Hero Slider
   ============================================================================ */
function initSlider() {
	const slider = document.querySelector('.hero-slider');
	const slides = document.querySelectorAll('.slide');
	const dots = document.querySelectorAll('.dot');
	let currentSlide = 0;
	let autoplayInterval;

	function goToSlide(n) {
		// Remove active class from all slides and dots
		slides.forEach(slide => slide.classList.remove('slide-active'));
		dots.forEach(dot => dot.classList.remove('active'));

		// Add active class to current slide and dot
		slides[n].classList.add('slide-active');
		dots[n].classList.add('active');

		currentSlide = n;
	}

	function nextSlide() {
		currentSlide = (currentSlide + 1) % slides.length;
		goToSlide(currentSlide);
	}

	function prevSlide() {
		currentSlide = (currentSlide - 1 + slides.length) % slides.length;
		goToSlide(currentSlide);
	}

	// Autoplay
	function startAutoplay() {
		autoplayInterval = setInterval(nextSlide, 3000);
	}

	function stopAutoplay() {
		clearInterval(autoplayInterval);
	}

	// Dot click handlers
	dots.forEach((dot, index) => {
		dot.addEventListener('click', () => {
			goToSlide(index);
			stopAutoplay();
			startAutoplay();
		});
	});

	// Pause on hover, resume on leave
	if (slider) {
		slider.addEventListener('mouseenter', stopAutoplay);
		slider.addEventListener('mouseleave', startAutoplay);
	}

	// Keyboard navigation
	document.addEventListener('keydown', (e) => {
		if (e.key === 'ArrowLeft') prevSlide();
		if (e.key === 'ArrowRight') nextSlide();
	});

	// Start autoplay
	startAutoplay();
}

/* ============================================================================
   Tab System
   ============================================================================ */
function initTabs() {
	const tabButtons = document.querySelectorAll('.tab-button');
	const tabPanels = document.querySelectorAll('.tab-panel');

	if (tabButtons.length === 0) return;

	tabButtons.forEach(button => {
		button.addEventListener('click', () => {
			const tabId = button.getAttribute('data-tab');

			// Remove active class from all buttons and panels
			tabButtons.forEach(btn => btn.classList.remove('active'));
			tabPanels.forEach(panel => panel.classList.remove('active'));

			// Add active class to clicked button and corresponding panel
			button.classList.add('active');
			const panel = document.getElementById(tabId);
			if (panel) {
				panel.classList.add('active');
			}
		});
	});
}

/* ============================================================================
   Mobile Menu
   ============================================================================ */
function initMobileMenu() {
	const menuToggle = document.querySelector('.mobile-menu-toggle');
	const mobileMenu = document.querySelector('.mobile-menu');
	const menuClose = document.querySelector('.mobile-menu-close');
	const menuLinks = document.querySelectorAll('.mobile-menu-list a');

	if (!menuToggle || !mobileMenu) return;

	// Toggle menu
	menuToggle.addEventListener('click', () => {
		mobileMenu.classList.add('active');
		document.body.style.overflow = 'hidden';
	});

	// Close menu
	const closeMenu = () => {
		mobileMenu.classList.remove('active');
		document.body.style.overflow = 'auto';
	};

	if (menuClose) {
		menuClose.addEventListener('click', closeMenu);
	}

	// Close menu when link is clicked
	menuLinks.forEach(link => {
		link.addEventListener('click', closeMenu);
	});

	// Close menu when clicking outside
	document.addEventListener('click', (e) => {
		if (!mobileMenu.contains(e.target) && !menuToggle.contains(e.target)) {
			closeMenu();
		}
	});
}

/* ============================================================================
   Smooth Scroll
   ============================================================================ */
function initSmoothScroll() {
	document.querySelectorAll('a[href^="#"]').forEach(anchor => {
		anchor.addEventListener('click', function(e) {
			const href = this.getAttribute('href');
			if (href === '#') return;

			const target = document.querySelector(href);
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

/* ============================================================================
   Utility Functions
   ============================================================================ */

// Debounce function for resize events
function debounce(func, wait) {
	let timeout;
	return function executedFunction(...args) {
		const later = () => {
			clearTimeout(timeout);
			func(...args);
		};
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
	};
}

// Check if element is in viewport
function isInViewport(element) {
	const rect = element.getBoundingClientRect();
	return (
		rect.top >= 0 &&
		rect.left >= 0 &&
		rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
		rect.right <= (window.innerWidth || document.documentElement.clientWidth)
	);
}

// Lazy load images
function lazyLoadImages() {
	const images = document.querySelectorAll('img[data-src]');
	const imageObserver = new IntersectionObserver((entries, observer) => {
		entries.forEach(entry => {
			if (entry.isIntersecting) {
				const img = entry.target;
				img.src = img.dataset.src;
				img.removeAttribute('data-src');
				observer.unobserve(img);
			}
		});
	});

	images.forEach(img => imageObserver.observe(img));
}

// Initialize lazy loading
if ('IntersectionObserver' in window) {
	lazyLoadImages();
}

/* ============================================================================
   Performance & Analytics
   ============================================================================ */

// Track slider interactions
document.addEventListener('click', function(e) {
	if (e.target.matches('.dot')) {
		// Track slide change
		if (typeof gtag !== 'undefined') {
			gtag('event', 'slider_interaction', {
				'slide_index': Array.from(document.querySelectorAll('.dot')).indexOf(e.target)
			});
		}
	}
});

// Track tab interactions
document.addEventListener('click', function(e) {
	if (e.target.matches('.tab-button')) {
		// Track tab change
		if (typeof gtag !== 'undefined') {
			gtag('event', 'tab_interaction', {
				'tab_name': e.target.getAttribute('data-tab')
			});
		}
	}
});

// Track CTA clicks
document.addEventListener('click', function(e) {
	const btn = e.target.closest('.btn');
	if (btn) {
		if (typeof gtag !== 'undefined') {
			gtag('event', 'cta_click', {
				'cta_text': btn.textContent,
				'cta_href': btn.href
			});
		}
	}
});

/* ============================================================================
   Form Handling
   ============================================================================ */

const searchForm = document.querySelector('.search-form');
if (searchForm) {
	searchForm.addEventListener('submit', function(e) {
		const query = this.querySelector('.search-input').value.trim();
		if (query) {
			// Track search
			if (typeof gtag !== 'undefined') {
				gtag('event', 'search', {
					'search_term': query
				});
			}
		}
	});
}

/* ============================================================================
   Accessibility Enhancements
   ============================================================================ */

// Add keyboard navigation for buttons
document.querySelectorAll('.btn, .tab-button, .dot').forEach(button => {
	button.addEventListener('keypress', function(e) {
		if (e.key === 'Enter' || e.key === ' ') {
			e.preventDefault();
			this.click();
		}
	});
});

// Announce live regions to screen readers
const announceToScreenReader = (message) => {
	const announcement = document.createElement('div');
	announcement.setAttribute('role', 'status');
	announcement.setAttribute('aria-live', 'polite');
	announcement.setAttribute('aria-atomic', 'true');
	announcement.textContent = message;
	announcement.style.position = 'absolute';
	announcement.style.left = '-10000px';
	announcement.style.width = '1px';
	announcement.style.height = '1px';
	announcement.style.overflow = 'hidden';
	document.body.appendChild(announcement);

	setTimeout(() => {
		announcement.remove();
	}, 3000);
};

/* ============================================================================
   Initialization
   ============================================================================ */

// Add loading complete indicator
window.addEventListener('load', function() {
	document.body.classList.add('page-loaded');
});
