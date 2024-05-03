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
                <button class="shadow">follows</button>
                <button class="shadow">following</button>
                <button class="shadow">Albums</button>
                <button class="shadow">Playlists</button>
                <button class="shadow">Estadísticas</button>
            </div>
            <div class="tabContent">
                <div id="following" class="hidden">
                    <div>
                        {{$following}}
                    </div>
                </div>
                <div id="followers" class="hidden">
                    <div>
                        {{$followers}}
                    </div>
                </div>
                <div id="Albums" class="hidden">
                    <div>
                        
                    </div>
                </div>
                <div id="Playlists" class="hidden">
                    <div>
                        
                    </div>
                </div>
                <div id="Estadísticas" class="hidden">
                    <div>
                        
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@section('footer')

@endsection
