
document.addEventListener('DOMContentLoaded', () => 
{
    const login = document.querySelector('.login_item');
    const register = document.querySelector('.register_item');

    if (!login || !register) return;

    const chiudi_menu = (menu_aperto, altri_menu) => 
    {
        altri_menu.querySelector('.auth_dropdown').classList.remove('is-visible');
        menu_aperto.querySelector('.auth_dropdown').classList.toggle('is-visible');
    };

   
    login.querySelector('.login').addEventListener('click', (ev) => 
    {
        ev.preventDefault();
        ev.stopPropagation();
        chiudi_menu(login, register);
    });

    register.querySelector('.register').addEventListener('click', (ev) => 
    {
        ev.preventDefault();
        ev.stopPropagation();
        chiudi_menu(register, login);
    });

    document.addEventListener('click', (ev) => 
    {
        if (!ev.target.closest('.login_item') && !ev.target.closest('.register_item')) 
        {
            login.querySelector('.auth_dropdown').classList.remove('is-visible');
            register.querySelector('.auth_dropdown').classList.remove('is-visible');
        }
    });

    const form_login = login.querySelector('form');
    form_login.addEventListener('submit', async (ev) => 
    {
        ev.preventDefault();
        const email = form_login.querySelector('.email-input').value;
        const password = form_login.querySelector('.password-input').value;
        const errore = form_login.querySelector('.form_message');

        try 
        {
            const res = await fetch('/login', 
                {
                method: 'POST',
                headers: 
                {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email, password })
            });

            const data = await res.json();

            if (res.ok && data.success) 
            {
                errore.textContent = 'Login completato!';
                errore.style.color = 'green';
                setTimeout(() => 
                {
                    window.location.href = '/';
                }, 1000);
            } 
            else 
            {
                errore.textContent = data.messaggio || 'Credenziali non valide';
                errore.style.color = 'red';
            }
        } 
        catch (error) 
        {
            console.error("Errore Login:", error);
        }
    });

    const form_register = register.querySelector('form');
    
    form_register.addEventListener('submit', async (ev) => 
    {
        ev.preventDefault();
        const errore = form_register.querySelector('.form_message');
        const form_data = new FormData(form_register);

        try 
        {
            const res = await fetch('/register', 
            {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json'
                },
                body: form_data
            });

            const data = await res.json();

            if (res.ok && data.success) 
            {
                errore.textContent = 'Registrazione effettuata!';
                errore.style.color = 'green';
                setTimeout(() => 
                {
                    window.location.href = '/';
                }, 1000);
            } 
            else 
                {
                errore.textContent = data.messaggio || 'Errore nella registrazione';
                errore.style.color = 'red';
            }
        } 
        catch (error) 
        {
            console.error(error);
            errore.textContent = 'Errore del server';
            errore.style.color = 'red';
        }
    });
});