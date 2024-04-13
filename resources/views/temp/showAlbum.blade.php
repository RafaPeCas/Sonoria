

@include('_layouts.header')

<main>

    <div class="text-white" id="home">

        <h1 class="text-white">Album</h1>

        <h2 class="text-white">{{ $album->name }}</h2>

        <img style='display:block; width:100px;height:100px;' id='base64image'
               src='data:image/jpeg;base64,{{ $album->image}}' />

               @if ($album->songs->count() > 0)
               <h2>Canciones del álbum:</h2>
               <ul>
                   @foreach ($album->songs as $song)
                   <li><a href="{{ route('songs.getSongById', ['id' => $song->id]) }}" style=" color: inherit; ">{{ $song->name }}</a></li>
                   @endforeach
               </ul>
             @else
               <p>No hay canciones en este álbum.</p>
            @endif

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

                        <input type="hidden" id="album_id" name="album_id" value="{{$album->id}}"><br>

                        <input type="submit" value="Guardar canción">
                    </form>
    </div>
    </main>

@include('_layouts.footer')
