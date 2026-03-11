import $ from 'jquery';

$(function () {
    const navbar = document.querySelector('.rn-navbar');
    const sectionIds = ['hero', 'why', 'how', 'features', 'testimonials', 'pricing', 'contact'];
    const navLinks = Array.from(document.querySelectorAll('.rn-nav-link'));
    const revealEls = Array.from(document.querySelectorAll('.reveal'));
    const counters = Array.from(document.querySelectorAll('.js-counter'));

    const setActiveLink = () => {
        const middle = window.scrollY + window.innerHeight * 0.35;

        for (const id of sectionIds) {
            const section = document.getElementById(id);

            if (!section) {
                continue;
            }

            const top = section.offsetTop;
            const bottom = top + section.offsetHeight;

            if (middle >= top && middle < bottom) {
                navLinks.forEach((link) => {
                    link.classList.toggle('active', link.getAttribute('href') === `#${id}`);
                });

                return;
            }
        }
    };

    const setNavbarState = () => {
        if (!navbar) {
            return;
        }

        navbar.classList.toggle('scrolled', window.scrollY > 10);
    };

    const animateCounter = (el) => {
        const target = Number(el.dataset.target || 0);

        if (!target || el.dataset.animated === '1') {
            return;
        }

        el.dataset.animated = '1';

        let current = 0;
        const steps = 36;
        const step = Math.max(1, Math.ceil(target / steps));

        const timer = window.setInterval(() => {
            current += step;

            if (current >= target) {
                current = target;
                window.clearInterval(timer);
            }

            el.textContent = current.toLocaleString('hu-HU');
        }, 24);
    };

    if ('IntersectionObserver' in window) {
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                }
            });
        }, { threshold: 0.16 });

        revealEls.forEach((el) => revealObserver.observe(el));

        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.45 });

        counters.forEach((el) => counterObserver.observe(el));
    } else {
        revealEls.forEach((el) => el.classList.add('is-visible'));
        counters.forEach((el) => animateCounter(el));
    }

    window.addEventListener('scroll', () => {
        setNavbarState();
        setActiveLink();
    }, { passive: true });

    setNavbarState();
    setActiveLink();

    const navCollapseEl = document.getElementById('rnNav');
    if (navCollapseEl) {
        navLinks.forEach((link) => {
            link.addEventListener('click', () => {
                navCollapseEl.classList.remove('show');
            });
        });
    }

    $('.rn-btn').on('mouseenter', function () {
        $(this).addClass('is-hovered');
    }).on('mouseleave', function () {
        $(this).removeClass('is-hovered');
    });
});
