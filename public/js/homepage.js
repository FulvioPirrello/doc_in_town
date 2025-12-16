document.addEventListener("DOMContentLoaded", () => 
{

    function apri_menu(container) 
    {
        container.querySelector('.filter-menu').classList.add('is-open');
        container.querySelector('.hamburger-btn').classList.add('is-active');
    }

    function chiudi_menu(exceptContainer) 
    {
        filtri.forEach(container => 
        {
            if (container !== exceptContainer) 
            {
                container.querySelector('.filter-menu').classList.remove('is-open');
                container.querySelector('.hamburger-btn').classList.remove('is-active');
            }
        });
    }

    const filtri = document.querySelectorAll('.filter-dropdown-container');

    filtri.forEach(container => 
    {
        const btn = container.querySelector('.hamburger-btn');
        const menu = container.querySelector('.filter-menu');

        if (btn && menu) 
        { 
            btn.addEventListener('click', (e) => 
            {
                e.stopPropagation();
            
                chiudi_menu(container); 

                const aperto = menu.classList.contains('is-open');
            
                if (aperto) 
                {
                    menu.classList.remove('is-open'); 
                    btn.classList.remove('is-active');
                } 
                else 
                {
                    apri_menu(container);
                }
            });
        }
    });

    document.addEventListener('click', (event) => 
    {
        filtri.forEach(container => 
        {
            if (!container.contains(event.target)) 
            {
                container.querySelector('.filter-menu').classList.remove('is-open');
                container.querySelector('.hamburger-btn').classList.remove('is-active');
            }
        });
    });

    const hamburgerBtn = document.getElementById('mobile-menu-btn');
    const mainMenu = document.getElementById('main-menu');

    if (hamburgerBtn && mainMenu) {
        hamburgerBtn.addEventListener('click', () => {
            hamburgerBtn.classList.toggle('is-active');
            mainMenu.classList.toggle('active');
        });
    }

});