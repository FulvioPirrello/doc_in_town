<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DOC IN TOWN</title>
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
    <script src="{{ asset('js/auth.js') }}"></script>
    <script src="{{ asset('js/homepage.js') }}"></script>
</head>
<body>
    @include('includes.navbar') 
    <section>
        <div class="homepage_box">
            <div class="search_item">

            <div class="filter-dropdown-container" id="filter-citta">
                    <button class="hamburger-btn" type="button">
                        <div class="top"></div>
                        <div class="meat"></div>
                        <div class="bottom"></div>
                    </button>

                    <nav class="filter-menu">
                        <a class="link1" href="{{ request()->fullUrlWithQuery(['citta' => null]) }}">-- Tutte le città --</a>
                        @foreach($citta as $city)
                            <a class="link1" href="{{ request()->fullUrlWithQuery(['citta' => $city->citta]) }}">
                                {{ $city->citta }}
                            </a>
                        @endforeach
                    </nav>
                </div>

                <form action="/" method="GET" style="width: 100%; display: flex; justify-content: center;">
                    @if(request('citta'))
                        <input type="hidden" name="citta" value="{{ request('citta') }}">
                    @endif
                    @if(request('specializzazione'))
                        <input type="hidden" name="specializzazione" value="{{ request('specializzazione') }}">
                    @endif
                    <input type="text" id="search_bar" name="search" placeholder="Cerca" value="{{ request('search') }}">
                </form>

                <div class="filter-dropdown-container" id="filter-spec">
                    <button class="hamburger-btn" type="button">
                        <div class="top"></div>
                        <div class="meat"></div>
                        <div class="bottom"></div>
                    </button>

                    <nav class="filter-menu">
                        <a class="link1" href="{{ request()->fullUrlWithQuery(['specializzazione' => null]) }}">-- Tutte le categorie --</a>
                        @foreach($specializzazioni as $spec)
                            <a class="link1" href="{{ request()->fullUrlWithQuery(['specializzazione' => $spec->tipo]) }}">
                                @if($spec->pic)
                                   <img src="{{ asset('img/'.$spec->pic) }}" width="15" style="margin-right:5px; vertical-align:middle;">
                                @endif
                                {{ $spec->tipo }}
                            </a>
                        @endforeach
                    </nav>
                </div>

            </div>
           <div class="box_doc"> 
                @if($medici->isEmpty())
                    <div class="no_results">
                        <h3>Nessun medico trovato.</h3>
                        <p>Prova a modificare i filtri o la ricerca.</p>
                        <a href="/" >Resetta filtri</a>
                    </div>
                @else
                    @foreach($medici as $medico)
                        <a class="doc_item" href="{{ route('mostra_professionista', $medico->id) }}">
                            <div class="doc">
                                <div class="doc_info">
                                    <div class="nome">
                                        {{ $medico->titolo }} {{ $medico->nome }} 
                                    </div>
                                    <div class="categoria">
                                        {{ $medico->specializzazione }}
                                        @if($medico->pic)
                                            <img src="{{ asset('img/' . $medico->pic) }}" alt="icon" class="spec_icon">
                                        @endif
                                    </div>
                                    <div class="sede">
                                        {{ $medico->sede_studio }}
                                        <div class="citta">{{ $medico->citta }}</div>
                                        <div class="mappa" id="maps"></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach

                @endif
            </div>
            <div class="paginazione">
                {{ $medici->withQueryString()->links() }}
            </div>
        </div>
    </section>
    @include('includes.footer')
</body>
</html>