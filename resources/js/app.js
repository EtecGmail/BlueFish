import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const navbar = document.querySelector('[data-navbar]');
    const toggle = document.querySelector('[data-navbar-toggle]');
    const menu = document.getElementById('menu-principal');

    const updateNavbarState = () => {
        if (!navbar) {
            return;
        }

        if (window.scrollY > 40) {
            navbar.classList.add('navbar--scrolled');
        } else {
            navbar.classList.remove('navbar--scrolled');
        }
    };

    updateNavbarState();
    window.addEventListener('scroll', updateNavbarState, { passive: true });

    if (navbar && toggle && menu) {
        const closeMenu = () => {
            navbar.dataset.open = 'false';
            toggle.setAttribute('aria-expanded', 'false');
        };

        closeMenu();

        toggle.addEventListener('click', () => {
            const isOpen = navbar.dataset.open === 'true';
            navbar.dataset.open = String(!isOpen);
            toggle.setAttribute('aria-expanded', String(!isOpen));
        });

        menu.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                if (window.matchMedia('(max-width: 767px)').matches) {
                    closeMenu();
                }
            });
        });

        window.addEventListener('resize', () => {
            if (window.matchMedia('(min-width: 768px)').matches) {
                closeMenu();
            }
        });
    }

    const fadeElements = document.querySelectorAll('.fade-in');
    if (fadeElements.length > 0 && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.2 }
        );

        fadeElements.forEach((element) => observer.observe(element));
    } else {
        fadeElements.forEach((element) => element.classList.add('is-visible'));
    }
});
