@extends('_layouts.template')

@section('title', 'home')

@section('links')
<link rel="stylesheet" href="{{asset("styles/playlists.css")}}">
@endsection

@section('content')
<div class="wholeSection">
    <div class="d-flex justify-content-center w-100 align-items-center">
        <h1 style="margin-right: 10px; margin-top: 10px;" class="text-white">TUS PLAYLISTS</h1>
    </div>

    <a style="margin-left: 30px; margin-top:30px" href="{{ route('home') }}" onmouseover="this.getElementsByTagName('img')[0].src='{{ asset('img/assets/homeHover.png') }}'" onmouseleave="this.getElementsByTagName('img')[0].src='{{ asset('img/assets/home.png') }}'">
        <img src="{{ asset('img/assets/home.png') }}" alt="" style="width: 50px; height: 50px; margin-top: -90px; filter: invert(100%);">
    </a>


    <div class="mainContainer">
        <div class="playlistsContainer text-white">
            <div class="formContainer text-white">
                <div id="playlists" class="hidden text-white tab">
                    <div>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn tableButton mt-3 mb-3 ms-5" data-bs-toggle="modal"
                                data-bs-target="#addPlaylistModal">
                                Agregar PLaylist
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="addPlaylistModal" tabindex="-1" aria-labelledby="addPlaylistModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content glass-morphism">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addPlaylistModalLabel">Agregar Nueva Playlist</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('playlist.store') }}"
                                                enctype="multipart/form-data">
                                                @csrf

                                                <div class="form-group">
                                                    <label for="name">Name:</label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        required maxlength="50">
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
                                                    <textarea class="form-control" id="description" name="description" maxlength="150" style="resize: none;"></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="image" class="form-label">Imagen de la playlist:</label>
                                                    <input type="file" id="image" name="image" class="form-control"
                                                        required>
                                                </div>

                                                <button type="submit" class="btn tableButton mt-3">Create Playlist</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

            </div>
            <div class="playlistWrap">
                @foreach ($playlists as $playlist)
                <a href="{{ route('playlist.show', ['id' => $playlist->id]) }}">
                    <div class="singleWrap">
                        <div class="singlePlaylist">
                            <img style="box-shadow: 1px 1px 10px 1px black; border-radius:20px" src="data:image/jpeg;base64,{{ $playlist->image }}" alt="{{ $playlist->name }}" >
                            <div class="textWrap">
                                <p class="m-0" style="font-weight:bolder; font-size: 1.2em">{{ $playlist->name }}</p>
                                <hr>
                                <p class="m-0">{{ $playlist->description }}</p>
                            </div>
                        </div>
                        <div class="w-100 h-100 d-flex justify-content-start align-items-center mx-4 pb-3">
                            <p class="m-0">Visibility: {{ $playlist->visibility }}</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection

@section('footer')

@endsection
