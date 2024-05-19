@extends('_layouts.template')

@section('title', 'home')

@section('links')
    <link rel="stylesheet" href="{{ asset('styles/home.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/songs/reproductionPanel.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script defer src="{{ asset('js/home.js') }}"></script>
@endsection

@section('content')

    <div id="home">
        <p hidden id="userId">{{ Auth::user()->id }}</p>
        <aside>
            <div class="display">
                <h1 class="d-flex justify-content-center pt-3 pb-2 text-white">Buscar artista</h1>
                <form id="searchForm">
                    <input style="box-shadow: 5px 5px 15px 2px black;" type="text" id="searchInput" name="term"
                        placeholder="Ingrese el nombre del artista...">
                </form>

                <div id="searchResults">

                </div>
                <script>
                    var typingTimer;
                    var doneTypingInterval = 300; // Intervalo de tiempo en milisegundos

                    $(document).ready(function() {
                        $('#searchInput').on('input', function() {
                            clearTimeout(typingTimer); // Limpiar el temporizador en cada entrada

                            var term = $(this).val();
                            if (term.length >= 1) {
                                typingTimer = setTimeout(function() {
                                    realizarBusqueda(
                                        term
                                    ); // Llamar a la función de búsqueda después del intervalo de tiempo
                                }, doneTypingInterval);
                            } else {
                                $('#searchResults').html(''); // Limpiar los resultados si el término es corto
                            }
                        });
                    });

                    function realizarBusqueda(term) {
                        $.ajax({
                            url: "{{ route('searchArtist') }}",
                            method: "POST",
                            data: {
                                term: term,
                                _token: '{{ csrf_token() }}'
                            },
                            beforeSend: function() {
                                // Puedes mostrar un mensaje de carga aquí
                            },
                            success: function(response) {
                                $('#searchResults').html(response);
                                console.log(response);
                            },
                            complete: function() {
                                // Aquí puedes ocultar el mensaje de carga si lo muestras
                            }
                        });
                    }
                </script>
            </div>
        </aside>

        <section id="content">
            <div class="contentHeader d-flex align-items-center">
                <div class="navMenu">
                    <a href="{{ route('playlist.index') }}">Tus playlists</a>
                    <a href="{{ route('user.profile', Auth::user()->id) }}">Tu perfil</a>
                    <a id="sLink" href="{{ route('spotify') }}">Conectar con Spotify</a>
                    <a class="dropdown-item bg-danger" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        Cerrar sesión
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <!-- No surplus words or unnecessary actions. - Marcus Aurelius -->
                </div>
            </div>
            <div class="contentBody">
                @if (count($playlists) > 0)
                    <div class="d-flex flex-column gap-5">
                        <div>
                            <h1>Playlists que sigues</h1>
                            <hr class="mb-0">
                        </div>
                        <div class="d-flex gap-5 lo-odio flex-row playlistContainer">
                            @foreach ($playlists as $playlist)
                                <div class="d-flex gap-5 @if ($loop->last) last-artist @endif">
                                    <a href="{{ route('playlist.show', ['id' => $playlist->id]) }}"
                                        class="text-decoration-none text-white">
                                        <div class="d-flex lo-odio">
                                            <h5 class="artist-name">{{ $playlist->name }}
                                            </h5>

                                            <img src="data:image/jpeg;base64,{{ $playlist->image }}"
                                                class="mixButton img-fluid">

                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="d-flex flex-column gap-5">
                    <div>
                        <h1>Artistas destacados</h1>
                        <hr class="mb-0">
                    </div>

                    <div class="d-flex gap-5 lo-odio playlistContainer">
                        @foreach ($users as $user)
                            <div class="d-flex gap-5 align-items-end @if ($loop->last) last-artist @endif">
                                <a href="{{ route('user.profile', ['id' => $user->id]) }}"
                                    class="text-decoration-none text-white">
                                    <div class="d-flex lo-odio">
                                        <h5 class="artist-name">{{ $user->name }}</h5>
                                            @if($user->avatar)
                                            <img class="mixButton" src="data:image/jpeg;base64,{{ $user->avatar }}">
                                            @else
                                            <img class="mixButton" src="{{ asset('img/cover/test.jpg') }}">
                                            @endif
                                       
                                        </img>
                                    </div>
                                </a>
                                @foreach ($user->albums as $album)
                                    <div class="d-flex lo-odio">
                                        <h5 class="album-name">{{ $album->name }}
                                        </h5>
                                        <a href="{{ route('album.show', ['id' => $album->id]) }}" class="imagencita"
                                            style="background-color: red">
                                            <img src="data:image/jpeg;base64,{{ $album->image }}" alt=""
                                                class="imagencita img-fluid">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                    </div>

                </div>
            </div>
        </section>


    </div>
@endsection

@section('footer')

@endsection
