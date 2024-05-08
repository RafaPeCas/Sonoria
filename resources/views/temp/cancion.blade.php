@include('_layouts.header')
<main>
<div class="text-white" id="home">

<h1>Prueba</h1>

<h2>{{ $song->title }}</h2>
<p>Explícita: {{ $song->explicit ? 'Sí' : 'No' }}</p>
<p>Activa: {{ $song->active ? 'Sí' : 'No' }}</p>
<p>Oculta: {{ $song->hidden ? 'Sí' : 'No' }}</p>
<p>Nombre: {{ $song->name }}</p>


    <audio controls="controls" autobuffer="autobuffer" autoplay="autoplay">
        <source src="data:audio/wav;base64,{{ $song->file }}" />
    </audio>




    <p>Reproducciones: {{ $song->reproductions }}</p>
    <p>ID del álbum: {{ $song->album_id }}</p>


    </div>

</main>
@include('_layouts.footer')
