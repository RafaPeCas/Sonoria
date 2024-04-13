

@include('_layouts.header')

<main>
<div class="text-white">
<h2>Crear nuevo álbum</h2>
<form action="{{ route('albums.store') }}" method="POST" enctype="multipart/form-data">
    @csrf <!-- Token CSRF para protección contra falsificación de solicitudes entre sitios -->

    <label for="name">Nombre:</label><br>
    <input type="text" id="name" name="name" required><br>

    <label for="image">Archivo de la imagen:</label><br>
    <input type="file" id="image" name="image" required><br>

    <input type="submit" value="Guardar álbum">
</form>
</div>
</main>

@include('_layouts.footer')
