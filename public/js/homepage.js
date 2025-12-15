document.addEventListener("DOMContentLoaded", () => 
{
    
    const filterContainers = document.querySelectorAll('.filter-dropdown-container');

    filterContainers.forEach(container => {
        const btn = container.querySelector('.hamburger-btn');
        const menu = container.querySelector('.filter-menu');

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
});