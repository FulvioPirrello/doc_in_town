<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DOC IN TOWN - {{ $user->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doc.css') }}">
    <link rel="stylesheet" href="{{ asset('css/utente.css') }}">
    <script src="{{ asset('js/auth.js') }}"></script>
    <script src="{{ asset('js/homepage.js') }}"></script>
</head>
<body>
    @include('includes.navbar') 
    
    <section>
        <div class="dettagli_utente">
            
            <div class="credenziali">
                <h1>I tuoi dati:</h1>
                <div class="box_utente">
                    <p><strong>Nome:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Iscritto dal:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            <div class="appuntamenti">
                <h1>I tuoi appuntamenti:</h1>
                
                @if($appuntamenti->isEmpty())
                    <p>Nessuna visita prenotata.</p>
                @else
                    <div class="appuntamenti_utente">
                        @foreach($appuntamenti as $appuntamento)
                            <div class="card-appuntamento">
                                <div class="header-card">
                                    <span class="data-visita">
                                        {{ \Carbon\Carbon::parse($appuntamento->data_visita)->format('d/m/Y') }}
                                    </span>
                                    <span class="ora-visita">
                                        ore {{ substr($appuntamento->ora_visita, 0, 5) }}
                                    </span>
                                </div>
                                
                                <div class="body-card">
                                    <h3>Dott. {{ $appuntamento->nome_medico }}</h3>
                                    <p class="specializzazione">{{ $appuntamento->specializzazione }}</p>
                                    <p class="indirizzo">
                                         {{ $appuntamento->sede_studio }}, {{ $appuntamento->citta }}
                                    </p>
                                    
                                    @if($appuntamento->note)
                                        <div class="note-box">
                                            <strong>Note:</strong> {{ $appuntamento->note }}
                                        </div>
                                    @endif

                                    <form action="{{ route('cancella_prenotazione', $appuntamento->id) }}" method="POST" style="margin-top: 15px;" onsubmit="return confirm('Sei sicuro di voler cancellare questo appuntamento?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-cancella">Cancella Appuntamento</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </section>

    @include('includes.footer')
</body>
</html>