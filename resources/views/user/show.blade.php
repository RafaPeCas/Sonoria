@extends('_layouts.template')

@section('title', $user->name)
<link rel="stylesheet" href="{{ asset('styles/profile.css') }}">
<script defer src="{{ asset('js/profile.js') }}"></script>
@section('links')

@endsection

@section('content')

    @if ($user->role === 'artist')
        <h1>Hola artista</h1>
    @else
        <div class="userHeader">
            <div class="userData">
                <div class="userImage">
                    <img src="{{ asset('img/userPictures/default.png') }}" alt="userPicture">
                </div>
                <div class="userName">
                    <h2>{{ $user->name }}</h2>
                    <hr>
                    <p>{{ $user->email }} (icono de correo)</p>
                    <p>{{ $user->birth }} (icono de tarta)</p>
                </div>
            </div>
            <div class="recentlyPlayed">
            </div>
        </div>
        <div class="tabContainer">
            <div class="tabs">
                <button class="tab-button" data-tab="followers">Seguidores</button>
                <button class="tab-button" data-tab="following">Siguiendo</button>
                <button class="tab-button" data-tab="albums">Álbums</button>
                <button class="tab-button" data-tab="statistics">Estadísticas</button>
            </div>
            <div class="tabContent">
                <div id="followers" class="hidden text-white tab">
                    <div>
                        <h1>Seguidores: {{ $followersCount }}</h1>
                        <ul>
                            @foreach($followers as $followerUser)
                                <a href="{{ route('user.profile', ['id' => $followerUser->id]) }}" class="">
                                    <li>{{ $followerUser->name }}</li>
                                </a>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div id="following" class="hidden text-white tab">
                    <div>
                        <h1>Siguiendo: {{ $followingCount }}</h1>
                        <ul>
                            @foreach($following as $followedUser)
                                <a href="{{ route('user.profile', ['id' => $followedUser->id]) }}" class="">
                                    <li>{{ $followedUser->name }}</li>
                                </a>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div id="albums" class="hidden text-white tab">
    <div>
        @if ($albums->isEmpty())
            <h1>No hay álbumes en este momento.</h1>
        @else
            @foreach($albums as $album)
                <a href="{{ route('album.show', ['id' => $album->id]) }}" class="imagencita"
                    style="background-color: red">
                    <h5 behavior="" direction="left" class="album-name">{{ $album->name }}</h5>
                    <img src="{{ $album->image }}" alt="" class="imagencita img-fluid">
                </a>
            @endforeach
        @endif
    </div>
</div>

                <div id="statistics" class="hidden tab">
                    <div>

                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@section('footer')

@endsection
