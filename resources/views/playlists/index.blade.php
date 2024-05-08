@extends('_layouts.template')

@section('title', 'home')

@section('links')
<link rel="stylesheet" href="{{asset("styles/playlists.css")}}">
@endsection

@section('content')
<div class="d-flex justify-content-center w-100 align-items-center">
    <h1 style="margin-right: 10px; margin-top: 10px;" class="text-white">TUS PLAYLISTS</h1>
</div>
<a style="margin-left: 10px;" href="{{ route('home') }}" onmouseover="this.getElementsByTagName('img')[0].src='{{ asset('img/assets/homeHover.png') }}'" onmouseleave="this.getElementsByTagName('img')[0].src='{{ asset('img/assets/home.png') }}'">
    <img src="{{ asset('img/assets/home.png') }}" alt="" style="width: 50px; height: 50px; margin-top: -90px;">
</a>

<div class="mainContainer">
    <div class="playlistsContainer text-white">
        <div class="playlistWrap">
            @foreach ($playlists as $playlist)
            <a href="{{ route('playlist.show', ['id' => $playlist->id]) }}">
                <div class="singlePlaylist">

                    @if ($playlist->image)
                    <img class="" src="data:image/jpeg;base64,{{ $playlist->image }}" alt="{{ $playlist->name }}" class="">
                    @endif
                    <div class="">
                        <h3>{{ $playlist->name }}</h3>
                        <hr>
                        <p>{{ $playlist->description }}</p>
                        <p>Visibility: {{ $playlist->visibility }}</p>
                    </div>

                </div>
            </a>
            @endforeach
        </div>
    </div>
    <div class="formContainer text-white">
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
</div>

@endsection

@section('footer')

@endsection