document.addEventListener("DOMContentLoaded", () => 
{
    // --- GESTIONE FILTRI (Codice esistente) ---
    const filterContainers = document.querySelectorAll('.filter-dropdown-container');

    filterContainers.forEach(container => {
        const btn = container.querySelector('.hamburger-btn');
        const menu = container.querySelector('.filter-menu');

        if (btn && menu) { // Controllo di sicurezza
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                
                closeAllMenus(container);

                const isOpen = menu.classList.contains('is-open');
                
                if (isOpen) {
                    closeMenu(container);
                } else {
                    openMenu(container);
                }
            });
        }
    });

    document.addEventListener('click', (event) => {
        filterContainers.forEach(container => {
            if (!container.contains(event.target)) {
                closeMenu(container);
            }
        });
    });

    function openMenu(container) {
        container.querySelector('.filter-menu').classList.add('is-open');
        container.querySelector('.hamburger-btn').classList.add('is-active');
    }

    function closeMenu(container) {
        container.querySelector('.filter-menu').classList.remove('is-open');
        container.querySelector('.hamburger-btn').classList.remove('is-active');
    }

    function closeAllMenus(exceptContainer) {
        filterContainers.forEach(container => {
            if (container !== exceptContainer) {
                closeMenu(container);
            }
        });
    }

    // --- GESTIONE MENU MOBILE NAVBAR (Corretto) ---
    const hamburgerBtn = document.getElementById('mobile-menu-btn');
    const mainMenu = document.getElementById('main-menu');

    if (hamburgerBtn && mainMenu) {
        hamburgerBtn.addEventListener('click', () => {
            hamburgerBtn.classList.toggle('is-active');
            mainMenu.classList.toggle('active');
        });
    }

});