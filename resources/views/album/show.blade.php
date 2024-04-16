@extends('_layouts.template')

@section('title', $album->name)

@section('links')
    <link rel="stylesheet" href="{{ asset('styles/home.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/album.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/songs/reproductionPanel.css') }}">
@endsection

@section('content')

    <section class="albumHeader p-5 w-100 text-white">
        <div class="d-flex gap-3 w-100">
            {{-- <img src="data:image/jpeg;base64,{{ $album->image }}" alt="{{ $album->name }} cover" id='base64image'
                class="bigAlbumImage"> --}}
                <img src="{{asset("img/cover/test.jpg")}}" alt="{{ $album->name }} cover" id='base64image'
                class="bigAlbumImage">
            <div class="albumInfo">
                <p class="m-0">Álbum</p>
                <h1 class="albumName">{{ $album->name }}</h1>
                <div class="d-flex justify-center align-items-center">
                    <img src="{{asset("img/cover/test.jpg")}}" alt="imagen" class="groupImage">
                    <p class="m-0 mx-2">
                        Nombre del grupo - Fecha del album - nº de canciones, duración total
                    </p>
                </div>
            </div>
        </div>


    </section>

    <section class="albumControls">
        <div>
            <button class="playButton">></button>
            <button class="suffleButton"></button>
            <button class="addButton"></button>
            <button class="downloadButton"></button>
            <button class="optionsButton"></button>
        </div>
    </section>
 <!-- Aquí comienza el formulario para agregar una nueva canción -->
 <form class="text-white" action="{{ route('songs.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="album_id" value="{{ $album->id }}">

    <label for="file">Archivo de canción:</label>
    <input type="file" id="file" name="file" required>
    <br>

    <label for="explicit">Explícita:</label>
    <input type="checkbox" id="explicit" name="explicit" value="1"><br>

    <label for="active">Activa:</label>
    <input type="checkbox" id="active" name="active" value="1">

    <label for="hidden">Oculta:</label>
    <input type="checkbox" id="hidden" name="hidden" value="1"><br>

    <label for="name">Nombre de la canción:</label>
    <input type="text" id="name" name="name" required>
    <br>

    <button type="submit">Agregar Canción</button>
</form>
    @if ($album->songs->count() > 0)
        <table class="text-white w-100 songsList">
            <thead>
                <th>#</th>
                <th>Título</th>
                <th>Reproducciones</th>
                <th><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20"
                        viewBox="0 0 30 30" fill="white">
                        <path
                            d="M15,3C8.373,3,3,8.373,3,15c0,6.627,5.373,12,12,12s12-5.373,12-12C27,8.373,21.627,3,15,3z M16,16H7.995 C7.445,16,7,15.555,7,15.005v-0.011C7,14.445,7.445,14,7.995,14H14V5.995C14,5.445,14.445,5,14.995,5h0.011 C15.555,5,16,5.445,16,5.995V16z">
                        </path>
                    </svg></th>
            </thead>
            <tbody>
                @foreach ($album->songs as $index => $song)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <a href="{{ route('songs.getSongById', ['id' => $song->id]) }}" style="color: inherit;">
                            {{ $song->name }}
                        </a>
                    </td>
                    <td>
                        {{ $song->reproductions }}
                    </td>
                    <td>
                        X
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay canciones en este álbum.</p>
    @endif

@endsection

@section('footer')
    @extends('user._reproductionPanel')
@endsection
