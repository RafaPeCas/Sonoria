<h2>Añadir canción:</h2>
<form class="text-white" action="{{ route('songs.store') }}" method="POST" enctype="multipart/form-data">
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

    <label for="genres">Géneros:</label><br>

    <select id="genres" name="genres[]" multiple>
        <option value="1">Rock</option>
        <option value="2">Pop</option>
        <option value="3">Rap</option>
    </select><br>

    <input type="hidden" id="album_id" name="album_id" value="{{ $album->id }}"><br>

    <input type="submit" value="Guardar canción">
</form>