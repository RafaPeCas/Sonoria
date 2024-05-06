@extends('_layouts.template')

@section('title', 'home')

@section('links')
    <link rel="stylesheet" href="{{ asset('styles/home.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/songs/reproductionPanel.css') }}">
@endsection

@section('content')

    <div id="home">


        <aside>
            <div class="display d-flex flex-column align-items-center">
                <button>Buscador</button>
                <button>Tu biblioteca</button>
                <button>Inicio</button>
                <button>Cutiño</button>
                <button>Maricón</button>
            </div>
        </aside>

        <section id="content">
            <div class="contentHeader d-flex align-items-center">
                <div class="navMenu">
                    <a href="">Tu biblioteca</a>
                    <a href="">Inicio</a>
                    <a href="">Recomendaciones</a>
                    <a href="{{route("user.profile", Auth::user()->id)}}">Tu perfil</a>
                    <a href="{{ route('logout') }}">Cerrar sesión</a>

                </div>
            </div>
            <div class="contentBody">
                <div class="d-flex flex-column gap-5">
                    <div>
                        <h1>Artistas destacados</h1>
                        <hr class="mb-0">
                    </div>

                    <div class="d-flex gap-5 lo-odio">
                        @foreach ($users as $user)
                            <div class="d-flex gap-5 align-items-end @if ($loop->last) last-artist @endif">
                                <a href="{{ route('user.profile', ['id' => $user->id]) }}" class="text-decoration-none text-white">
                                    <div class="d-flex lo-odio">
                                        <marquee behavior="" direction="left" class="artist-name">{{ $user->name }}</marquee>
                                        <button class="mixButton">
                                        </button>
                                    </div>
                                </a>
                                @foreach ($user->albums as $album)
                                    <div class="d-flex lo-odio">
                                        <marquee behavior="" direction="left" class="album-name">{{ $album->name }}</marquee>
                                        <a href="{{ route('album.show', ['id' => $album->id]) }}" class="imagencita"
                                            style="background-color: red">
                                            <img src="{{ $album->image }}" alt="" class="imagencita img-fluid">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                    </div>
                    
                </div>
            </div>
        </section>


    </div>
@endsection

@section('footer')

@endsection
