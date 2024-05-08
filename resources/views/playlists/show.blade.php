@extends('_layouts.template')

@section('title', $playlist->name)

@section('links')
<link rel="stylesheet" href="{{ asset('styles/home.css') }}">
<link rel="stylesheet" href="{{ asset('styles/album.css') }}">
<link rel="stylesheet" href="{{ asset('styles/songs/reproductionPanel.css') }}">
<script defer src="{{ asset('js/songsControl.js') }}"></script>
@endsection

@section('content')

<section class="albumHeader p-5 w-100 text-white d-flex">
    <div class="d-flex gap-3 w-100">
        {{-- <img src="data:image/jpeg;base64,{{ $album->image }}" alt="{{ $album->name }} cover" id='base64image'
        class="bigAlbumImage"> --}}
        <img src="{{ asset('img/cover/test.jpg') }}" alt="{{ $playlist->name }} cover" id='base64image' class="bigAlbumImage">
        <div class="albumInfo">
            <p class="m-0">Álbum</p>
            <h1 class="albumName">{{ $playlist->name }}</h1>
            <div class="d-flex justify-center align-items-center">
                <img src="{{ asset('img/cover/test.jpg') }}" alt="imagen" class="groupImage">
                <p class="m-0 mx-2">
                    Nombre del grupo - Fecha del playlist - Canciones: X, duración total
                </p>
            </div>
        </div>
    </div>
    <div class="">
        <a href="{{ route('home') }}" onmouseover="this.getElementsByTagName('img')[0].src='{{ asset('img/assets/homeHover.png') }}'" onmouseleave="this.getElementsByTagName('img')[0].src='{{ asset('img/assets/home.png') }}'">
            <img src="{{ asset('img/assets/home.png') }}" alt="">
        </a>
    </div>
</section>

@if ($playlist->songs()->count() > 0)
<table class="text-white w-100 songsList">
    <thead>
        <th>#</th>
        <th>Título</th>
        <th>Reproducciones</th>
        <th>Playlist</th>
        <th>

        </th>

    </thead>
    <tbody>
        @foreach ($album->songs as $index => $song)
        <tr id="song_{{ $song->id }}">
            <td>{{ $index + 1 }}</td>
            <td>
                <a href="#" class="song-link noDecoration" data-id="{{ $song->id }}" data-src="data:audio/wav;base64,{{ $song->file }}" style="color: inherit;">
                    {{ $song->name }}
                </a>
            </td>
            <td>
                {{ $song->reproductions }}
            </td>
            <td><a href="#">Añadir</a></td>
            <td>
                @if (Auth::check() && (Auth::user()->id === 1 || Auth::user()->id === $song->album->user_id))
                <button class="delete-song-btn" data-id="{{ $song->id }}">Eliminar</button>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>

</table>
@else
<p class="text-white">No hay canciones en esta palylist.</p>
@endif

<section id="reproductionPanel">
    
    <div id="songInfo">
        <div class="d-flex custom align-items-center h-100 pl-2">
            <div>
                <img class="coverImg" src="">
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
                <audio controls="controls" autobuffer="autobuffer" autoplay="autoplay" id="audio-player">
                    <!-- Aquí puedes colocar la fuente de audio -->
                    Tu navegador no soporta audio.
                </audio>
                <div class="audio-controls">
                    <button class="play-pause">Play/Pause</button>
                    <button class="seek-backward">«</button>
                    <button class="seek-forward">»</button>
                    <button class="prev-song-btn">
                        << /button>
                            <button class="next-song-btn">></button>
                            <button class="random-mode-btn">Aleatorio</button>

                            <input type="range" class="volume-slider" min="0" max="100" value="100">
                </div>

                <div class="progress-container">
                    <div class="progress-bar"></div>
                </div>
            </div>

            <div>

            </div>
        </div>
    </div>

</section>

<script>
    var csrfToken = '{{ csrf_token() }}';
</script>
@endsection

@section('footer')
@endsection