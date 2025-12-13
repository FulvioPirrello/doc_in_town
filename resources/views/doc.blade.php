<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DOC IN TOWN - {{ $item->nome }}</title>
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doc.css') }}">
    <link rel="stylesheet" href="{{ asset('css/maps.css') }}">
    <script src="{{ asset('js/auth.js') }}"></script>
    <script src="{{ asset('js/homepage.js') }}"></script>
    <script src="{{ asset('js/doc.js') }}"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body>
    @include('includes.navbar') 
    
    <section>
        <div class="dettagli_doc">
            
            <div class="colonna-sx">
                
                <div class="doc_info_page">
                    <div class="nome">
                        {{ $item->titolo }} {{ $item->nome }} 
                    </div>
                    
                    <div class="categoria">
                        {{ $item->specializzazione }}
                        @if($item->pic)
                            <img src="{{ asset('img/'.$item->pic) }}" alt="icon" class="spec_icon">
                        @endif
                    </div>
                </div> 

                <div class="booking-box">

                    @if(session('success'))
                        <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('aggiungi_professionista', $item->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Data:</label>
                            <input type="date" name="data" min="{{ date('Y-m-d') }}" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Orario:</label>
                            <select name="ora" class="form-input" required>
                                <option value="">-- Seleziona orario --</option>
                                <option disabled>Mattina</option>
                                <option value="09:00">09:00 - 09:30</option>
                                <option value="09:30">09:30 - 10:00</option>
                                <option value="10:00">10:00 - 10:30</option>
                                <option value="10:30">10:30 - 11:00</option>
                                <option value="11:00">11:00 - 11:30</option>
                                <option value="11:30">11:30 - 12:00</option>
                                <option value="12:00">12:00 - 12:30</option>
                                <option value="12:30">12:30 - 13:00</option>
                                <option disabled>Pomeriggio</option>
                                <option value="14:00">14:00 - 14:30</option>
                                <option value="14:30">14:30 - 15:00</option>
                                <option value="15:00">15:00 - 15:30</option>
                                <option value="15:30">15:30 - 16:00</option>
                                <option value="16:00">16:00 - 16:30</option>
                                <option value="16:30">16:30 - 17:00</option>
                                <option value="17:00">17:00 - 17:30</option>
                                <option value="17:30">17:30 - 18:00</option>
                                <option value="18:00">18:00 - 18:30</option>
                                <option value="18:30">18:30 - 19:00</option>
                            </select>
                        </div>
                        
                        <textarea class="note_input" name="note" placeholder="Note per l'appuntamento" maxlength="250"></textarea>
                        <button type="submit" class="btn-prenota">
                            CONFERMA PRENOTAZIONE
                        </button>
                    </form>
                </div>

            </div>

            <div class="colonna-dx">
                <div id="map-{{ $item->id }}" 
                    class="mappa" 
                    data-address="{{ $item->sede_studio }}"
                    data-city="{{ $item->citta }}"
                    data-name="{{ $item->nome }}">
                </div>
            </div>
        </div>
    </section>

    @include('includes.footer')
</body>
</html>