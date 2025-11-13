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

    const adminSidebar = document.querySelector('[data-admin-sidebar]');
    const adminSidebarToggle = document.querySelector('[data-admin-sidebar-toggle]');
    const adminSidebarClose = document.querySelector('[data-admin-sidebar-close]');
    const adminSidebarBackdrop = document.querySelector('[data-admin-sidebar-backdrop]');

    if (adminSidebar && adminSidebarToggle) {
        const setSidebarState = (open) => {
            adminSidebar.dataset.open = open ? 'true' : 'false';
            adminSidebarToggle.setAttribute('aria-expanded', String(open));
            if (adminSidebarBackdrop) {
                adminSidebarBackdrop.hidden = !open;
            }
        };

        const closeSidebar = () => {
            setSidebarState(false);
            adminSidebarToggle.focus();
        };

        setSidebarState(false);

        adminSidebarToggle.addEventListener('click', () => {
            const isOpen = adminSidebar.dataset.open === 'true';
            setSidebarState(!isOpen);
        });

        if (adminSidebarClose) {
            adminSidebarClose.addEventListener('click', closeSidebar);
        }

        if (adminSidebarBackdrop) {
            adminSidebarBackdrop.addEventListener('click', closeSidebar);
        }

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && adminSidebar.dataset.open === 'true') {
                closeSidebar();
            }
        });

        window.addEventListener('resize', () => {
            if (window.matchMedia('(min-width: 64.0625rem)').matches) {
                setSidebarState(false);
                if (adminSidebarBackdrop) {
                    adminSidebarBackdrop.hidden = true;
                }
            }
        });
    }
});
