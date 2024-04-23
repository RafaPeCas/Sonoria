@extends('_layouts.template')

@section('title', $user->name)

@section('links')
    <link rel="stylesheet" href="{{ asset('styles/home.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/album.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/songs/reproductionPanel.css') }}">
    <script defer src="{{ asset('js/songsControl.js') }}"></script>
@endsection

@section('content')

    <section class="albumHeader p-5 w-100 text-white">
        <div class="d-flex gap-3 w-100">
            <img src="" id='base64image' class="bigAlbumImage">
            <div class="albumInfo">
                <p class="m-0">Álbum</p>
                <h1 class="albumName"></h1>
                <div class="d-flex justify-center align-items-center">
                    <img src="{{ asset('img/cover/test.jpg') }}" alt="imagen" class="groupImage">
                    <p class="m-0 mx-2">
                        {{ $user->name }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="albumControls">
        <div>
            <button class="playButton">></button>
            <button class="suffleButton"></button>
            <button class="addButton"></button>
            <button class="downloadButton"></button>
            <button class="optionsButton"></button>
        </div>
    </section>

    <div style="color: white" class="d-flex">
        {{ $user->name }}
        {{ $user->email }}
        {{ $user->gender }}
        {{ $user->birth }}
        {{ $user->gender }}
    </div>

@endsection

@section('footer')

@endsection
