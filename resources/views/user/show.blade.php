@extends('_layouts.template')

@section('title', $user->name)

@section('links')
    <link rel="stylesheet" href="{{ asset('styles/home.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/album.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/songs/reproductionPanel.css') }}">
    <script defer src="{{ asset('js/songsControl.js') }}"></script>
@endsection

@section('content')

    @if ($user->role === 'artist')
        <h1>Hola artista</h1>
    @else
        <div class="userHeader">
            <div class="userData">
                <div class="userImage">
                    <img src="{{ asset('img/userPictures/default.png') }}" alt="userPicture">
                    <div class="d-flex mt-3 justify-content-center"> <a href="{{ route('user.edit', $user->id) }}" class="btn  btn-primary">Editar perfil</a></div>
                </div>
                <div class="userName">
                    <h2>{{ $user->name }}</h2>
                    <hr>
                    
                    <p>
                        <img src="{{asset('img/logos/email-svgrepo-com.svg')}}" alt="icono email" height="30" >
                        <span class="spaceIcon">{{ $user->email }}</span>
                    </p>
                    <p>
                        @if($user->birth)
                        <img src="{{asset('img/logos/birthdate-svgrepo-com.svg')}}" alt="icono tarta"> {{ $user->birth }}
                        @else
                        <img src="{{asset('img/logos/birthdate-svgrepo-com.svg')}}" alt="icono tarta" height="30"> Fecha no disponible
                        @endif
                    </p>
                    <p><img src="{{asset('img/logos/gender-svgrepo-com.svg')}}" alt="icono genero" height="34" >    <span class="mr-3">{{ trans($user->gender) }}</span></p>
                    <p><img src="{{asset('img/logos/profile-svgrepo-com.svg')}}" alt="icono perfil" height="36">  <span class="spaceIcon">{{ trans($user->role->name) }}</span></p>
                  
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
    </div>


@endsection

@section('footer')

@endsection
