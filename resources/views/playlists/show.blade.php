@extends('_layouts.template')

@section('title', $playlist->name)

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
                <img src="data:image/jpeg;base64,{{ $playlist->image }}" alt="{{ $playlist->name }} cover" id='base64image'
                    class="bigAlbumImage">
                <div class="albumInfo">
                    <p class="m-0 fw-bolder" style="font-size: 1.5em;">Playlist de <a class="userLink" href="{{route("user.profile", ['id' =>$playlist->user()->first()->id]) }}">{{$playlist->user()->first()->name}}</a><div id="mediaPlayer">
            </div></a></p>
                    <p class="m-0 fw-bolder">Nombre:</p>
                    <p class="m-0 albumName">{{ $playlist->name }}</p>
                    <p class="m-0 fw-bolder">Descripción:</p>
                    <p class="m-0 albumDescription">{{ $playlist->description }}</p>
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

        @if ($playlist->songs()->count() > 0)
            <div class="songsWrap">
                <table class="text-white w-100 songsList">
                    <thead>
                        <th class="espacio"></th>
                        <th>#</th>
                        <th>Título</th>
                        <th>Reproducciones</th>
                        <th>
                            @if (Auth::check() && (Auth::user()->id === 1 || Auth::user()->id === $playlist->user()->first()->id))
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20"
                                    viewBox="0 0 30 30" fill="white">
                                    <path
                                        d="M15,3C8.373,3,3,8.373,3,15c0,6.627,5.373,12,12,12s12-5.373,12-12C27,8.373,21.627,3,15,3z M16,16H7.995 C7.445,16,7,15.555,7,15.005v-0.011C7,14.445,7.445,14,7.995,14H14V5.995C14,5.445,14.445,5,14.995,5h0.011 C15.555,5,16,5.445,16,5.995V16z">
                                    </path>
                                </svg>
                            @endif
                        </th>

                    </thead>
                    <tbody>
                        @foreach ($playlist->songs as $index => $song)
                            <tr id="song_{{ $song->id }}">
                                <td class="espacio"></td>
                                <td hidden id="image{{ $song->id }}">{{ $song->album->image }}</td>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <a href="#" class="song-link noDecoration" data-id="{{ $song->id }}"
                                        data-src="data:audio/wav;base64,{{ $song->file }}" style="color: inherit;"
                                        onclick="getSongId(this)">
                                        {{ $song->name }}
                                    </a>
                                </td>
                                <td>
                                    {{ $song->reproductions }}
                                </td>
                                <td>
                                    @if (Auth::check() && (Auth::user()->id === 1 || Auth::user()->id === $playlist->user()->first()->id))
                                        <button class="delete-song tableButton" data-id="{{ $song->id }}"
                                            data-playlist-id="{{ $playlist->id }}">Eliminar</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        @else
            <p class="text-white">No hay canciones en esta playlist.</p>
        @endif

        <section id="reproductionPanel">

            <div id="songInfo">
                <div class="d-flex custom align-items-center h-100 pl-2">
                    <div>
                        <img class="coverImg" id="coverImage" src="data:image/jpeg;base64,{{ $playlist->image }}">
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

        function getSongId(e) {
            var actualSongId = e.getAttribute("data-id")
            var reproducionImage = document.querySelector("#image" + actualSongId).innerHTML
            document.querySelector("#coverImage").src = "data:image/jpeg;base64," + reproducionImage;
        }
    </script>
@endsection

@section('footer')
@endsection
