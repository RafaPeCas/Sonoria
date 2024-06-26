@extends('_layouts.template')

@section('title', $album->name)

@section('links')
    <link rel="stylesheet" href="{{ asset('styles/home.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/album.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/songs/reproductionPanel.css') }}">
    <script defer src="{{ asset('js/songsControl.js') }}"></script>
@endsection

@section('content')
    <div class="wholeSection">
        <section class="albumHeader p-5 w-100 text-white d-flex">
            <div class="d-flex gap-3 w-100">
                @if ($album->image)
                    <img src="data:image/jpeg;base64,{{ $album->image }}" alt="{{ $album->name }} cover" id="base64image"
                        class="bigAlbumImage">
                @else
                    <img src="{{ asset('img/cover/test.jpg') }}" alt="{{ $album->name }} cover" id="base64image"
                        class="bigAlbumImage">
                @endif

                <div class="albumInfo">
                    <p class="m-0">Álbum</p>
                    <h1 class="albumName">{{ $album->name }}</h1>
                    <div class="d-flex justify-center align-items-center">
                        @if ($album->user->avatar )
                            <img src="data:image/jpeg;base64,{{ $album->user->avatar }}" alt="imagen" class="groupImage">
                        @else
                            <img src="{{ asset('img/cover/test.jpg') }}" alt="imagen" class="groupImage">
                        @endif

                        <p class="m-0 mx-2">
                            <a class="userLink" href="{{route("user.profile", ['id' =>$album->user->id]) }}">{{ $album->user->name }}</a> - {{ date('Y', strtotime($album->created_at)) }} - Canciones:
                            {{ $totalSongs }}
                        </p>

                        @if (Auth::check() && (Auth::user()->id === 1 || Auth::user()->id === $album->user_id))

                        <!-- Botón para abrir el modal de actualización y eliminación del álbum -->
                        <button type="button" class="tableButton" data-bs-toggle="modal"
                            data-bs-target="#updateAlbumModal">
                            Actualizar y Eliminar Álbum
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="updateAlbumModal" tabindex="-1" aria-labelledby="updateAlbumModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content glass-morphism">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateAlbumModalLabel">Actualizar Álbum</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="text-white" action="{{ route('albums.update') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <!-- Campo oculto para pasar la ID del álbum -->
                                            <input type="hidden" name="album_id" value="{{ $album->id }}">
                                            <div class="">
                                                <label for="name" class="form-label">Nombre del Álbum:</label>
                                                <input type="text" id="name" name="name" class="form-control"
                                                    value="{{ $album->name }}" required>
                                            </div>

                                            <div class="">
                                                <label for="image" class="form-label">Imagen del Álbum:</label>
                                                <input type="file" id="image" name="image" class="form-control">
                                            </div>


                                            <button type="submit" class="btn tableButton mt-2">Actualizar Álbum</button>

                                        </form>
                                        <!-- Botón para Eliminar Álbum -->
                                        <form action="{{ route('albums.delete') }}" method="POST">
                                            @csrf
                                            <!-- Campo oculto para enviar la ID del álbum -->
                                            <input type="hidden" name="album_id" value="{{ $album->id }}">
                                            <button type="submit" class="btn tableButton mt-2">Eliminar Álbum</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif


                    </div>
                </div>
            </div>
            <div class="">
                <a href="{{ route('home') }}"
                    onmouseover="this.getElementsByTagName('img')[0].src='{{ asset('img/assets/homeHover.png') }}'"
                    onmouseleave="this.getElementsByTagName('img')[0].src='{{ asset('img/assets/home.png') }}'">
                    <img src="http://127.0.0.1:8000/img/assets/home.png" alt=""
    style="
        width: 50px;
        margin-top: -20px;
        filter: invert(100%);
    ">
                </a>
            </div>
        </section>

        @if ($album->songs->count() > 0)
            <div class="songsWrap">

                <table class="text-white w-100 songsList">
                    <thead>
                        <th class="espacio"></th>
                        <th>#</th>
                        <th>Título</th>
                        <th>Reproducciones</th>
                        <th>Playlist</th>
                        <th>
                            @if (Auth::check() && (Auth::user()->id === 1 || Auth::user()->id === $album->user_id))
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20"
                                    viewBox="0 0 30 30" fill="white">
                                    <path
                                        d="M15,3C8.373,3,3,8.373,3,15c0,6.627,5.373,12,12,12s12-5.373,12-12C27,8.373,21.627,3,15,3z M16,16H7.995 C7.445,16,7,15.555,7,15.005v-0.011C7,14.445,7.445,14,7.995,14H14V5.995C14,5.445,14.445,5,14.995,5h0.011 C15.555,5,16,5.445,16,5.995V16z">
                                    </path>
                                </svg>
                            @endif
                        </th>

                    </thead>
                    <div class="cobadonga">
                        <tbody>
                            @foreach ($album->songs as $index => $song)
                                <tr id="song_{{ $song->id }}">
                                    <td class="espacio"></td>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <a href="#" class="song-link noDecoration" data-id="{{ $song->id }}"
                                            data-src="data:audio/wav;base64,{{ $song->file }}" style="color: inherit;">
                                            {{ $song->name }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $song->reproductions }}
                                    </td>
                                    <td>
                                        <button type="button" class="tableButton" data-bs-toggle="modal"
                                            data-bs-target="#addSongToPlaylistModal{{ $index }}">
                                            Añadir a Playlist
                                        </button>

                                        <div class="modal fade" id="addSongToPlaylistModal{{ $index }}"
                                            tabindex="-1"
                                            aria-labelledby="addSongToPlaylistModalLabel{{ $index }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content glass-morphism">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="addSongToPlaylistModalLabel{{ $index }}">Añadir
                                                            Canción a
                                                            la
                                                            Playlist</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="text-white" method="POST"
                                                            action="{{ route('playlist.addSong') }}">
                                                            @csrf
                                                            <input type="hidden" name="songId"
                                                                value="{{ $song->id }}">
                                                            <select name="playlistId" id="playlistId">
                                                                @foreach (Auth::user()->playlists as $playlist)
                                                                    <option value="{{ $playlist->id }}">
                                                                        {{ $playlist->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <button type="submit"
                                                                class="tableButton mt-2">Añadir</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                    <td>
                                        @if (Auth::check() && (Auth::user()->id === 1 || Auth::user()->id === $song->album->user_id))
                                            <button type="button" class="tableButton" data-bs-toggle="modal"
                                                data-bs-target="#editSongModal{{ $index }}">
                                                Editar
                                            </button>

                                            <!-- Modal de edición -->
                                            <div class="modal fade" id="editSongModal{{ $index }}" tabindex="-1"
                                                aria-labelledby="editSongModalLabel{{ $index }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content glass-morphism">
                                                        <!-- Contenido del modal de edición -->
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="editSongModalLabel{{ $index }}">Editar Canción
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Formulario para editar la canción -->
                                                            <form class="text-white" method="POST"
                                                                action="{{ route('song.update', ['id' => $song->id]) }}"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                @method('POST')

                                                                <div class="mb-3">
                                                                    <label for="edit_name" class="form-label">Nombre de la
                                                                        canción:</label>
                                                                    <input type="text" id="edit_name" name="name"
                                                                        class="form-control" value="{{ $song->name }}">
                                                                </div>

                                                                <!-- Aquí deberías incluir los campos que deseas editar -->
                                                                <div class="mb-3">
                                                                    <label for="edit_file" class="form-label">Archivo de
                                                                        canción:</label>
                                                                    <input type="file" id="edit_file" name="file"
                                                                        class="form-control">
                                                                </div>

                                                                <div class="mb-3 form-check">
                                                                    <input type="checkbox" id="edit_explicit"
                                                                        name="explicit" value="1"
                                                                        class="form-check-input">
                                                                    <label for="edit_explicit"
                                                                        class="form-check-label">Explícita</label>
                                                                </div>

                                                                <div class="mb-3 form-check">
                                                                    <input type="checkbox" id="edit_active"
                                                                        name="active" value="1"
                                                                        class="form-check-input">
                                                                    <label for="edit_active"
                                                                        class="form-check-label">Activa</label>
                                                                </div>

                                                                <div class="mb-3 form-check">
                                                                    <input type="checkbox" id="edit_hidden"
                                                                        name="hidden" value="1"
                                                                        class="form-check-input">
                                                                    <label for="edit_hidden"
                                                                        class="form-check-label">Oculta</label>
                                                                </div>



                                                                <button type="submit" class="btn tableButton">Guardar
                                                                    Cambios</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <button class="delete-song-btn tableButton"
                                                data-id="{{ $song->id }}">Eliminar</button>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </div>
                </table>
            </div>
        @else
            <p class="text-white">No hay canciones en este álbum.</p>
        @endif

        @if (Auth::check() && (Auth::user()->id === 1 || Auth::user()->id === $album->user_id))
            <!-- Button trigger modal -->
            <button type="button" class="tableButton" data-bs-toggle="modal" data-bs-target="#addSongModal">
                Agregar Canción
            </button>

            <!-- Modal -->
            <div class="modal fade" id="addSongModal" tabindex="-1" aria-labelledby="addSongModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content glass-morphism">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addSongModalLabel">Agregar Nueva Canción</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="text-white" action="{{ route('songs.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="album_id" value="{{ $album->id }}">

                                <div class="mb-3">
                                    <label for="file" class="form-label">Archivo de canción:</label>
                                    <input type="file" id="file" name="file" class="form-control" required>
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" id="explicit" name="explicit" value="1"
                                        class="form-check-input">
                                    <label for="explicit" class="form-check-label">Explícita</label>
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" id="active" name="active" value="1"
                                        class="form-check-input">
                                    <label for="active" class="form-check-label">Activa</label>
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" id="hidden" name="hidden" value="1"
                                        class="form-check-input">
                                    <label for="hidden" class="form-check-label">Oculta</label>
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre de la canción:</label>
                                    <input type="text" id="name" name="name" class="form-control" required>
                                </div>

                                <button type="submit" class="btn tableButton">Agregar Canción</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <section id="reproductionPanel">
            <div id="songInfo">
                <div class="d-flex custom align-items-center h-100 pl-2">
                    <div>
                        <img class="coverImg"
                            src="{{ $album->image ? 'data:image/jpeg;base64,' . $album->image : asset('img/cover/test.jpg') }}"
                            alt="{{ $album->name }}">
                    </div>
                    <div>
                        <div class="songTitle">
                            <div>
                                <h2></h2>
                            </div>
                        </div>
                        <p id="albumNameRepro"></p>
                    </div>
                </div>
            </div>
            <div id="mediaPlayer">
                <div class="d-flex custom align-items-center h-100 pl-2">
                    <div class="custom-audio-player">
                        <audio controls="controls" autobuffer="autobuffer" autoplay="autoplay" id="audio-player" hidden>
                            Tu navegador no soporta audio.
                        </audio>
                        <div class=" d-flex justify-content-center align-items-center">
                            <div class="audio-controls">
                                <button class="prev-song-btn p-0" style="width: 30px;"><i class="fa-solid fa-backward-step large-icon"></i></button>
                                <button class="seek-backward p-0" style="width: 40px;"><i class="fa-solid fa-backward large-icon"></i></button>
                            </div>
                            <div class="progress-container mt-0 mb-0">
                                <div class="progress-bar">
                                </div>
                            </div>
                            <div class="audio-controls">
                                <button class="seek-forward p-0" style="width: 40px;"><i class="fa-solid fa-forward large-icon"></i></button>
                                <button class="next-song-btn p-0" style="width: 30px;"><i class="fa-solid fa-forward-step large-icon"></i></button>

                            </div>
                        </div>

                        <div class="audio-controls d-flex justify-content-center mt-2">
                            <button class="random-mode-btn"><i id="icon-random" class="fa-solid fa-shuffle large-icon"></i></button>
                            <button class="play-pause"><i id="icon-play" class="fa-solid fa-play large-icon"></i></button>
                            <input type="range" class="volume-slider" min="0" max="100" value="100">
                        </div>
                    </div>

                    <div>

                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        var csrfToken = '{{ csrf_token() }}';
    </script>
@endsection

@section('footer')

@endsection
