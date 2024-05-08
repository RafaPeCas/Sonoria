@extends('_layouts.template')

@section('title', 'home')

@section('links')

@endsection

@section('content')
<h1 class="text-white">TUS PLAYLISTS</h1>
<div class="container text-white">
    <h1>Playlists</h1>
    <div class="row">
        @foreach ($playlists as $playlist)
        <a href="{{ route('playlist.show', ['id' => $playlist->id, 'name' => $playlist->name]) }}">
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    @if ($playlist->image)
                    <img class="bd-placeholder-img card-img-top" src="data:image/jpeg;base64,{{ $playlist->image }}" alt="{{ $playlist->name }}">
                    @endif
                    <div class="card-body">
                        <h3>{{ $playlist->name }}</h3>
                        <p>{{ $playlist->description }}</p>
                        <p>Visibility: {{ $playlist->visibility }}</p>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
<div class="container text-white">
    <h2>Create Playlist</h2>
    <form method="POST" action="{{ route('playlist.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="visibility">Visibility:</label>
            <select class="form-control" id="visibility" name="visibility" required>
                <option value="public">Public</option>
                <option value="private">Private</option>
            </select>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>

        <div class="form-group">
            <label for="image" class="form-label">Imagen de la playlist:</label>
            <input type="file" id="image" name="image" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Playlist</button>
    </form>
</div>
@endsection

@section('footer')

@endsection
