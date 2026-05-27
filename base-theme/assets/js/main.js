/**
 * Monoliet Starter — Main JS
 *
 * Vanilla JS only. Handles mobile menu, sticky header, smooth scroll.
 */

(function () {
    'use strict';

    var hamburger = document.querySelector('.site-header__hamburger');
    var drawer = document.querySelector('.mobile-drawer');
    var overlay = document.querySelector('.mobile-drawer__overlay');
    var drawerClose = document.querySelector('.mobile-drawer__close');

    function openDrawer() {
        drawer.classList.add('is-open');
        overlay.classList.add('is-visible');
        hamburger.classList.add('is-active');
        hamburger.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
        drawer.classList.remove('is-open');
        overlay.classList.remove('is-visible');
        hamburger.classList.remove('is-active');
        hamburger.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    if (hamburger) {
        hamburger.addEventListener('click', function () {
            var isOpen = drawer.classList.contains('is-open');
            isOpen ? closeDrawer() : openDrawer();
        });
    }

    if (overlay) {
        overlay.addEventListener('click', closeDrawer);
    }

    if (drawerClose) {
        drawerClose.addEventListener('click', closeDrawer);
    }

    // Close drawer on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && drawer && drawer.classList.contains('is-open')) {
            closeDrawer();
        }
    });

    // Close drawer on link click (navigation)
    if (drawer) {
        var links = drawer.querySelectorAll('a');
        for (var i = 0; i < links.length; i++) {
            links[i].addEventListener('click', closeDrawer);
        }
    }

    // Sticky header shadow on scroll
    var header = document.querySelector('.site-header');
    if (header) {
        var scrolled = false;
        window.addEventListener('scroll', function () {
            if (window.scrollY > 10 && !scrolled) {
                header.style.boxShadow = 'var(--shadow-md)';
                scrolled = true;
            } else if (window.scrollY <= 10 && scrolled) {
                header.style.boxShadow = 'var(--shadow-sm)';
                scrolled = false;
            }
        }, { passive: true });
    }

    // Smooth scroll for anchor links
    var anchorLinks = document.querySelectorAll('a[href^="#"]');
    for (var j = 0; j < anchorLinks.length; j++) {
        anchorLinks[j].addEventListener('click', function (e) {
            var targetId = this.getAttribute('href');
            if (targetId === '#') return;

            var target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                var headerHeight = header ? header.offsetHeight : 0;
                var top = target.getBoundingClientRect().top + window.pageYOffset - headerHeight;
                window.scrollTo({ top: top, behavior: 'smooth' });
            }
        });
    }
})();
