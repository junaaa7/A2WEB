

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

/**
 * Sistem Animasi Scroll Frontend A2Web (GPU-accelerated, ringan, 60fps).
 * Hanya aktif di halaman landing frontend (`html.dark-frontend`), bukan panel Admin.
 */
if (document.documentElement.classList.contains('dark-frontend')) {
    const prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const initFrontendScrollSystem = () => {
        const htmlEl = document.documentElement;
        const progressBar = document.getElementById('scroll-progress-bar');
        const navbar = document.getElementById('main-navbar');
        const heroSection = document.getElementById('hero');
        const heroLogoParallax = document.getElementById('hero-logo-parallax');
        const backToTopBtn = document.getElementById('back-to-top');
        const navLinks = Array.from(document.querySelectorAll('[data-scrollspy-link]'));
        const mobileLinks = Array.from(document.querySelectorAll('[data-scrollspy-mobile]'));
        const spySections = ['hero', 'portfolio', 'proses', 'layanan', 'faq', 'kontak']
            .map((id) => document.getElementById(id))
            .filter(Boolean);

        // Pemetaan section ke item navbar aktif (#proses tetap menyorot Portofolio agar transisi rapi)
        const sectionNavMap = {
            hero: '#hero',
            portfolio: '#portfolio',
            proses: '#portfolio',
            layanan: '#layanan',
            faq: '#faq',
            kontak: null,
        };

        const markRevealed = (el) => {
            if (!el) {
                return;
            }
            const rawDelay = parseInt(el.getAttribute('data-reveal-delay') || '0', 10) || 0;
            const isMobile = window.innerWidth < 768;
            const effectiveDelay = isMobile ? Math.min(rawDelay, 120) : rawDelay;
            const baseDuration = el.classList.contains('hero-reveal') ? 420 : (isMobile ? 500 : 650);

            el.style.setProperty('--reveal-delay', `${effectiveDelay}ms`);
            el.classList.add('is-visible');

            window.setTimeout(() => {
                el.classList.add('reveal-done');
                el.style.willChange = 'auto';
            }, effectiveDelay + baseDuration + 50);
        };

        const markRevealedImmediately = (el) => {
            if (!el) {
                return;
            }
            el.style.setProperty('--reveal-delay', '0ms');
            el.classList.add('is-visible', 'reveal-done');
            el.style.willChange = 'auto';
        };

        // 1. Scroll Reveal Bertahap dengan Fallback Anti-Blank
        const revealElements = Array.from(document.querySelectorAll('[data-reveal]'));

        if (!prefersReducedMotion && 'IntersectionObserver' in window && revealElements.length > 0) {
            revealElements.forEach((el) => {
                const rawDelay = parseInt(el.getAttribute('data-reveal-delay') || '0', 10) || 0;
                const isMobile = window.innerWidth < 768;
                const clampedDelay = isMobile ? Math.min(rawDelay, 120) : rawDelay;
                el.style.setProperty('--reveal-delay', `${clampedDelay}ms`);
            });

            htmlEl.classList.add('js-reveal-ready');

            // Pastikan browser mencatat state awal sebelum trigger animasi masuk Hero
            void document.body.offsetHeight;

            const observer = new IntersectionObserver(
                (entries, obs) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            markRevealed(entry.target);
                            obs.unobserve(entry.target);
                        }
                    });
                },
                {
                    threshold: 0.06,
                    rootMargin: '0px 0px -40px 0px',
                }
            );

            const isNearTopOnLoad = window.scrollY < 100;

            revealElements.forEach((el) => {
                if (el.classList.contains('hero-reveal') && isNearTopOnLoad) {
                    window.requestAnimationFrame(() => {
                        markRevealed(el);
                    });
                    return;
                }

                const rect = el.getBoundingClientRect();
                if (rect.top <= window.innerHeight * 0.92) {
                    markRevealedImmediately(el);
                } else {
                    observer.observe(el);
                }
            });

            // Pengaman ekstra jika scroll cepat ke bagian paling bawah halaman
            const revealVisibleFallback = () => {
                const nearBottom = window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 40;
                revealElements.forEach((el) => {
                    if (el.classList.contains('is-visible') || el.offsetParent === null) {
                        return;
                    }
                    const rect = el.getBoundingClientRect();
                    if (nearBottom || rect.top <= window.innerHeight - 16) {
                        markRevealed(el);
                        observer.unobserve(el);
                    }
                });
            };

            window.addEventListener('scroll', revealVisibleFallback, { passive: true });
        } else {
            revealElements.forEach(markRevealedImmediately);
        }

        // 2. Scroll Progress Bar, Navbar State, ScrollSpy, Hero Parallax (Desktop), Back-to-Top
        let rafPending = false;

        const updateScrollUI = () => {
            rafPending = false;
            const scrollY = window.scrollY || window.pageYOffset || 0;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const progress = docHeight > 0 ? Math.min(Math.max(scrollY / docHeight, 0), 1) : 0;

            if (progressBar) {
                progressBar.style.transform = `scaleX(${progress.toFixed(4)})`;
            }

            if (navbar) {
                navbar.classList.toggle('is-scrolled', scrollY > 40);
            }

            if (backToTopBtn) {
                const showBackToTop = scrollY > 450;
                backToTopBtn.classList.toggle('opacity-100', showBackToTop);
                backToTopBtn.classList.toggle('scale-100', showBackToTop);
                backToTopBtn.classList.toggle('pointer-events-auto', showBackToTop);
                backToTopBtn.classList.toggle('opacity-0', !showBackToTop);
                backToTopBtn.classList.toggle('scale-90', !showBackToTop);
                backToTopBtn.classList.toggle('pointer-events-none', !showBackToTop);
            }

            // Hero Subtle Parallax khusus Desktop (>= 1024px)
            if (heroLogoParallax && heroSection) {
                if (!prefersReducedMotion && window.innerWidth >= 1024) {
                    const heroHeight = heroSection.offsetHeight || 650;
                    const heroProgress = Math.min(Math.max(scrollY / heroHeight, 0), 1);
                    const translateY = (heroProgress * 40).toFixed(2);
                    const fadeOpacity = (1 - heroProgress * 0.65).toFixed(3);
                    heroLogoParallax.style.transform = `translate3d(0, ${translateY}px, 0)`;
                    heroLogoParallax.style.opacity = fadeOpacity;
                } else {
                    heroLogoParallax.style.transform = '';
                    heroLogoParallax.style.opacity = '';
                }
            }

            // ScrollSpy ringkas & akurat
            if (spySections.length > 0 && (navLinks.length > 0 || mobileLinks.length > 0)) {
                let activeSectionId = 'hero';
                const spyOffset = 140;

                for (let i = 0; i < spySections.length; i++) {
                    const section = spySections[i];
                    if (section.offsetTop - spyOffset <= scrollY) {
                        activeSectionId = section.id;
                    }
                }

                if (scrollY + window.innerHeight >= document.documentElement.scrollHeight - 24) {
                    const lastSection = spySections[spySections.length - 1];
                    if (lastSection) {
                        activeSectionId = lastSection.id;
                    }
                }

                const targetHref = sectionNavMap[activeSectionId] ?? null;

                navLinks.forEach((link) => {
                    link.classList.toggle('is-active', targetHref !== null && link.getAttribute('href') === targetHref);
                });

                mobileLinks.forEach((link) => {
                    link.classList.toggle('is-active', targetHref !== null && link.getAttribute('href') === targetHref);
                });
            }
        };

        const scheduleScrollUpdate = () => {
            if (!rafPending) {
                rafPending = true;
                window.requestAnimationFrame(updateScrollUI);
            }
        };

        window.addEventListener('scroll', scheduleScrollUpdate, { passive: true });
        window.addEventListener('resize', scheduleScrollUpdate, { passive: true });
        updateScrollUI();

        if (backToTopBtn) {
            backToTopBtn.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: prefersReducedMotion ? 'auto' : 'smooth',
                });
            });
        }
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFrontendScrollSystem);
    } else {
        initFrontendScrollSystem();
    }
}
