<div id="home">

<h1 class="text-white">Prueba</h1>

<h2>{{ $song->title }}</h2>
<p>Explícita: {{ $song->explicit ? 'Sí' : 'No' }}</p>
<p>Activa: {{ $song->active ? 'Sí' : 'No' }}</p>
<p>Oculta: {{ $song->hidden ? 'Sí' : 'No' }}</p>
<p>Nombre: {{ $song->name }}</p>

<img style='display:block; width:100px;height:100px;' id='base64image'
       src='data:image/jpeg;base64,{{ $song->image}}' />

<audio controls="controls" autobuffer="autobuffer" autoplay="autoplay">
    <source src="data:audio/wav;base64,{{ $song->file }}" />
</audio>




<p>Reproducciones: {{ $song->reproductions }}</p>
<p>ID del álbum: {{ $song->album_id }}</p>


    </div>
