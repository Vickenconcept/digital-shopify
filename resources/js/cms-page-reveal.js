/**
 * Scroll-reveal & hero load animations for GrapesJS CMS pages.
 * Auto-targets YJV template classes (.pg-*, .h-*) and inline grid cards.
 */
export function initCmsPageReveal() {
    const root = document.querySelector('.cms-page-content');
    if (!root) {
        return;
    }

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const markVisible = (el) => {
        el.classList.add('yjv-in-view');
    };

    const prepareReveal = (el, delayIndex = 0) => {
        if (el.classList.contains('yjv-reveal')) {
            return;
        }
        el.classList.add('yjv-reveal');
        el.style.setProperty('--yjv-delay', `${delayIndex * 0.09}s`);
    };

    // Hero — animate on page load
    root.querySelectorAll('.pg-hero-text, .pg-hero-img-wrap, .h-hero-text, .h-hero-img-wrap, .yjv-hero-part').forEach((el) => {
        el.classList.add('yjv-hero-part');
    });

    // Known template cards & blocks
    const revealSelectors = [
        '.pg-feature',
        '.pg-intro-inner',
        '.pg-split-img-wrap',
        '.pg-split-text',
        '.pg-cta-inner',
        '.h-cat',
        '.h-step',
        '.h-deco-card',
        '.h-section-head',
        '.h-blog-cta-text',
        '.yjv-card',
        '.yjv-reveal',
        '[data-yjv-reveal]',
    ];

    revealSelectors.forEach((selector) => {
        root.querySelectorAll(selector).forEach((el) => prepareReveal(el));
    });

    // Stagger children in template grids
    [
        '.pg-features-grid',
        '.h-cats-grid',
        '.h-blog-cta-deco',
        '.yjv-stagger-grid',
    ].forEach((gridSelector) => {
        root.querySelectorAll(gridSelector).forEach((grid) => {
            [...grid.children].forEach((child, index) => prepareReveal(child, index));
        });
    });

    // GrapesJS inline CSS grids (feature cards, multi-column blocks)
    root.querySelectorAll('section div[style*="grid-template-columns"]').forEach((grid) => {
        if (grid.children.length < 2) {
            return;
        }
        [...grid.children].forEach((child, index) => prepareReveal(child, index));
    });

    // Generic sections (single container) fade up once
    root.querySelectorAll(':scope > section, :scope > div > section').forEach((section) => {
        if (section.querySelector('.pg-hero-inner, .h-hero-inner, [style*="grid-template-columns"]')) {
            return;
        }
        if (section.querySelector('.yjv-reveal')) {
            return;
        }
        prepareReveal(section);
    });

    if (reducedMotion) {
        root.classList.add('yjv-page-ready');
        root.querySelectorAll('.yjv-reveal, .yjv-hero-part').forEach(markVisible);
        return;
    }

    requestAnimationFrame(() => {
        root.classList.add('yjv-page-ready');
    });

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }
                markVisible(entry.target);
                observer.unobserve(entry.target);
            });
        },
        {
            threshold: 0.12,
            rootMargin: '0px 0px -48px 0px',
        },
    );

    root.querySelectorAll('.yjv-reveal:not(.yjv-hero-part)').forEach((el) => observer.observe(el));
}

document.addEventListener('DOMContentLoaded', initCmsPageReveal);
