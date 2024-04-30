@include('_layouts.header')

<main>
    <div class="text-white" id="home">
        <h1 class="text-white">Playlist</h1>
        <h2 class="text-white">{{ $playlist->name }}</h2>

        @if ($playlist->image)
        <img style='display:block; width:100px;height:100px;' id='base64image'
        src='data:image/jpeg;base64,{{ $playlist->image}}' />
         @endif

        @if ($playlist->songs->count() > 0)
            <h2>Canciones de la playlist:</h2>
            <ul>
                @foreach ($playlist->songs as $song)
                    <li><a href="{{ route('songs.getSongById', ['id' => $song->id]) }}" style="color: inherit;">{{ $song->name }}</a></li>
                @endforeach
            </ul>
        @else
            <p>No hay canciones en esta playlist.</p>
        @endif
    </div>
</main>

@include('_layouts.footer')
