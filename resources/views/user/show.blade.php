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
                    <img src="{{ $user->image }}" alt="imagen" class="groupImage">
                    <p class="m-0 mx-2">
                        {{ $user->name }}
                    </p>
                </div>
            </div>
        </div>
    </section>



    <div style="color: white">
        <h1>Perfil de {{ $user->name }}</h1>

        @if ($isFollowing)
            <form action="{{ route('user.unfollow', $user->id) }}" method="POST">
                @csrf
                <button type="submit">Dejar de Seguir</button>
            </form>
        @else
            <form action="{{ route('user.follow', $user->id) }}" method="POST">
                @csrf
                <button type="submit">Seguir</button>
            </form>
        @endif

        <h2>Número de Seguidores: {{ $followersCount }}</h2>
        @if ($followersCount > 0)
            <h3>Seguidores:</h3>
            <ul>
                @foreach ($followers as $follower)
                    <li>{{ $follower->name }}</li>
                @endforeach
            </ul>
        @endif

        <h2>Número de Siguiendo: {{ $followingCount }}</h2>
        @if ($followingCount > 0)
            <h3>Siguiendo:</h3>
            <ul>
                @foreach ($following as $followed)
                    <li>{{ $followed->name }}</li>
                @endforeach
            </ul>
        @endif

        @if ($albums->count() > 0)
            <h2>Álbumes:</h2>
            <div class="album-container">
                @foreach ($albums as $album)
                    <div class="ms-3 d-flex lo-odio">
                        <marquee behavior="" direction="left" class="album-name">{{ $album->name }}</marquee>
                        <a href="{{ route('album.show', ['id' => $album->id]) }}" class="imagencita"
                            style="background-color: red">
                            <img src="{{ $album->image }}" alt="" class="imagencita img-fluid">
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>


@endsection

@section('footer')

@endsection
