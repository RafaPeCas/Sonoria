@extends("_layouts.admin.template")

@section("title", "Index de admin")

@section("links")
    @vite("resources/js/show_song.js")
@endsection

@section("content")
    <h1>Esta es la página de administrador</h1>
    <div id="show_song">

    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <h2>Crear nueva canción</h2>
    <form action="{{ route('songs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf <!-- Token CSRF para protección contra falsificación de solicitudes entre sitios -->

        <label for="file">Archivo de la canción:</label><br>
        <input type="file" id="file" name="file" required><br>

        <label for="name">Nombre:</label><br>
        <input type="text" id="name" name="name" required><br>

        <label for="explicit">Explícita:</label>
        <input type="checkbox" id="explicit" name="explicit" value="1"><br>

        <label for="active">Activa:</label>
        <input type="checkbox" id="active" name="active" value="1">

        <label for="hidden">Oculta:</label>
        <input type="checkbox" id="hidden" name="hidden" value="1"><br>

        <label for="album_id">ID del álbum:</label><br>
        <input type="number" id="album_id" name="album_id" required><br>

        <label for="genres">Géneros:</label><br>

        <label for="file">Archivo de la imagen:</label><br>
        <input type="file" id="image" name="image" required><br>
        <!-- Input múltiple para seleccionar varios géneros -->
        <select id="genres" name="genres[]" multiple>
            <option value="1">Rock</option>
            <option value="2">Pop</option>
            <option value="3">Rap</option>
        </select><br>

        <label for="playlists">Listas de reproducción:</label><br>
        <!-- Input múltiple para seleccionar varias listas de reproducción -->
        <select id="playlists" name="playlists[]" multiple>
            <option value="1">Playlist 1</option>
            <option value="2">Playlist 2</option>
            <option value="3">Playlist 3</option>
        </select><br>

        <input type="submit" value="Guardar canción">
    </form>
@endsection
