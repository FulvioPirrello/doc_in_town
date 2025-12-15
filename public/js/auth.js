
document.addEventListener('DOMContentLoaded', () => 
{
    const loginItem = document.querySelector('.login_item');
    const registerItem = document.querySelector('.register_item');

    if (!loginItem || !registerItem) return;

    const toggleDropdown = (activeItem, otherItem) => 
    {
        otherItem.querySelector('.auth_dropdown').classList.remove('is-visible');
        activeItem.querySelector('.auth_dropdown').classList.toggle('is-visible');
    };

   
    loginItem.querySelector('.login').addEventListener('click', (ev) => 
    {
        ev.preventDefault();
        ev.stopPropagation();
        toggleDropdown(loginItem, registerItem);
    });

    registerItem.querySelector('.register').addEventListener('click', (ev) => 
    {
        ev.preventDefault();
        ev.stopPropagation();
        toggleDropdown(registerItem, loginItem);
    });

    document.addEventListener('click', (ev) => 
    {
        if (!ev.target.closest('.login_item') && !ev.target.closest('.register_item')) 
        {
            loginItem.querySelector('.auth_dropdown').classList.remove('is-visible');
            registerItem.querySelector('.auth_dropdown').classList.remove('is-visible');
        }
    });

    const loginForm = loginItem.querySelector('form');
    loginForm.addEventListener('submit', async (ev) => 
    {
        ev.preventDefault();
        const email = loginForm.querySelector('.email-input').value;
        const password = loginForm.querySelector('.password-input').value;
        const errore = loginForm.querySelector('.form_message');

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

            if (res.ok && data.success) {
                errore.textContent = 'Login effettuato!';
                errore.style.color = 'green';
                window.location.href = '/';
            } else {
                errore.textContent = data.messaggio || 'Credenziali non valide';
                errore.style.color = 'red';
            }
        } catch (err) {
            console.error("Errore Login:", err);
            errore.textContent = 'Errore di connessione';
            errore.style.color = 'red';
        }
    });

    const registerForm = registerItem.querySelector('form');
    registerForm.addEventListener('submit', async (ev) => {
        ev.preventDefault();
        const errore = registerForm.querySelector('.form_message');
        const formData = new FormData(registerForm);

        try {
            const res = await fetch('/register', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await res.json();

            if (res.ok && data.success) {
                errore.textContent = 'Registrazione completata!';
                errore.style.color = 'green';
                setTimeout(() => {
                    window.location.href = '/';
                }, 1000);
            } else {
                errore.textContent = data.messaggio || 'Errore nella registrazione';
                errore.style.color = 'red';
            }
        } catch (error) {
            console.error(error);
            errore.textContent = 'Errore del server';
            errore.style.color = 'red';
        }
    });
});