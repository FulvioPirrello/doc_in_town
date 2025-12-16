<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Profilo - DOC IN TOWN</title>
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/utente.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modifica_profilo.css') }}">
</head>
<body>
    @include('includes.navbar')

    <div class="box_modifica">
        <div class="item_profilo">
            
            <h2>Modifica i tuoi dati</h2>

            @if ($errors->any())
                <div class="errore">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('aggiorna_profilo') }}" method="POST">
                @csrf
                
                <div class="form_modifica">
                    <label>Username</label>
                    <input type="text" name="username" value="{{ old('username', $utente->name) }}" class="form-input" required>
                </div>

                <div class="form_modifica">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email', $utente->email) }}" class="form-input" required>
                </div>

                <p >Lasciare vuoto se non si vuole cambiare la password</p>

                <div class="form_modifica">
                    <label>Nuova Password</label>
                    <input type="password" name="password" class="form-input">
                </div>

                <div class="form_modifica">
                    <label>Conferma Nuova Password</label>
                    <input type="password" name="password_confirmation" class="form-input">
                </div>

                <div class="salva_modifiche">
                    <button type="submit" class="btn_salva">Salva Modifiche</button>
                    <a href="{{ route('profilo_utente') }}" class="btn-cancel">Annulla</a>
                </div>
            </form>
        </div>
    </div>

    @include('includes.footer')
</body>
</html>