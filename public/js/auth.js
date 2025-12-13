document.addEventListener('DOMContentLoaded', () => 
{
    const loginItem = document.querySelector('.login_item');
    const registerItem = document.querySelector('.register_item');

    if (!loginItem || !registerItem) return; 

    const toggleDropdown = (item) => 
    {
        const dropdown = item.querySelector('.auth_dropdown');
        dropdown.classList.toggle('is-visible');
    };

    loginItem.querySelector('.login').addEventListener('click', (ev) => 
    {
        ev.preventDefault();
        ev.stopPropagation(); 
        toggleDropdown(loginItem);
        registerItem.querySelector('.auth_dropdown').classList.remove('is-visible');
    });

    registerItem.querySelector('.register').addEventListener('click', (ev) => 
    {
        ev.preventDefault();
        ev.stopPropagation();
        toggleDropdown(registerItem);
        loginItem.querySelector('.auth_dropdown').classList.remove('is-visible');
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

        try {
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

            const text = await res.text();
            console.log("Risposta Server:", text);

            let data;
            try {
                data = JSON.parse(text);
            } catch (e) {
                throw new Error("Risposta non valida dal server (vedi console)");
            }

            if (data.success) 
            {
                errore.textContent = 'Login effettuato!';
                errore.style.color = 'green';
                location.href = '/';
            } 
            else 
            {
                errore.textContent = data.messaggio || 'Login fallito';
                errore.style.color = 'red';
            }
        } catch (err) {
            console.error(err);
            errore.textContent = 'Errore di connessione';
            errore.style.color = 'red';
        }
    });
    

    const registerForm = registerItem.querySelector('form');
    registerForm.addEventListener('submit', async (ev) => 
    {
        ev.preventDefault();
        const errore = registerForm.querySelector('.form_message');
        const formData = new FormData(registerForm);

        try {
            const res = await fetch('/register', 
            {
                method: 'POST',
                headers: 
                {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: formData,
                redirect: 'follow'
            });

            if (res.ok || res.status === 200) 
            {
                try {
                    const data = await res.json();
                    
                    if (data.success) 
                    {
                        errore.textContent = 'Registrazione completata!';
                        errore.style.color = 'green';
                        setTimeout(() => {
                            location.href = '/';
                        }, 500);
                    } 
                    else 
                    {
                        errore.textContent = data.messaggio || 'Registrazione fallita';
                        errore.style.color = 'red';
                    }
                } catch (jsonError) {
                    errore.textContent = 'Registrazione completata!';
                    errore.style.color = 'green';
                    setTimeout(() => {
                        location.href = '/';
                    }, 500);
                }
            }
            else 
            {
                errore.textContent = 'Errore nella registrazione';
                errore.style.color = 'red';
            }
        } catch (error) {
            errore.textContent = 'Errore di connessione';
            errore.style.color = 'red';
        }
    });
    
});