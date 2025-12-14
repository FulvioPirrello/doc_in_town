
document.addEventListener('DOMContentLoaded', () => {
    // Seleziona i contenitori di Login e Registrazione
    const loginItem = document.querySelector('.login_item');
    const registerItem = document.querySelector('.register_item');

    // Se non ci sono (es. utente già loggato), esce
    if (!loginItem || !registerItem) return;

    // Funzione per mostrare/nascondere i menu a tendina
    const toggleDropdown = (activeItem, otherItem) => {
        // Chiude l'altro se aperto
        otherItem.querySelector('.auth_dropdown').classList.remove('is-visible');
        // Apre/Chiude quello cliccato
        activeItem.querySelector('.auth_dropdown').classList.toggle('is-visible');
    };

    // --- EVENT LISTENERS PER I BOTTONI ---
    // Usa stopPropagation per evitare che il click si propaghi al document (che chiuderebbe il menu)
    loginItem.querySelector('.login').addEventListener('click', (ev) => {
        ev.preventDefault();
        ev.stopPropagation();
        toggleDropdown(loginItem, registerItem);
    });

    registerItem.querySelector('.register').addEventListener('click', (ev) => {
        ev.preventDefault();
        ev.stopPropagation();
        toggleDropdown(registerItem, loginItem);
    });

    // Chiude i menu se si clicca fuori dalle aree di login/register
    document.addEventListener('click', (ev) => {
        if (!ev.target.closest('.login_item') && !ev.target.closest('.register_item')) {
            loginItem.querySelector('.auth_dropdown').classList.remove('is-visible');
            registerItem.querySelector('.auth_dropdown').classList.remove('is-visible');
        }
    });

    // --- LOGICA LOGIN (ASINCRONA) ---
    const loginForm = loginItem.querySelector('form');
    loginForm.addEventListener('submit', async (ev) => {
        ev.preventDefault(); // Ferma il refresh della pagina
        const email = loginForm.querySelector('.email-input').value;
        const password = loginForm.querySelector('.password-input').value;
        const errore = loginForm.querySelector('.form_message');

        try {
            // Chiamata REST API al server
            const res = await fetch('/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json' // Importante per ricevere JSON da Laravel
                },
                body: JSON.stringify({ email, password })
            });

            const data = await res.json(); // Attende la conversione della risposta in JSON

            if (res.ok && data.success) {
                errore.textContent = 'Login effettuato!';
                errore.style.color = 'green';
                window.location.href = '/'; // Ricarica la home da loggato
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

    // --- LOGICA REGISTRAZIONE (ASINCRONA) ---
    const registerForm = registerItem.querySelector('form');
    registerForm.addEventListener('submit', async (ev) => {
        ev.preventDefault();
        const errore = registerForm.querySelector('.form_message');
        const formData = new FormData(registerForm); // Raccoglie tutti i campi del form automaticamente

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
                // Visualizza l'errore specifico (es. "Password troppo corta")
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