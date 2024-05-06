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
                <div class="userName">
                    <h2>{{ $user->name }}</h2>
                    <hr>
                    <p>{{ $user->email }} (icono de correo)</p>
                    <p>{{ $user->birth }} (icono de tarta)</p>

                    @if (Auth::check() && Auth::user()->id !== $user->id)

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

                    @endif

                </div>
            </div>
            <div class="recentlyPlayed">
            </div>
            <div class="mt-5 me-3 ms-3">
                <a href="{{ route('home') }}"
                    onmouseover="this.getElementsByTagName('img')[0].src='{{ asset('img/assets/homeHover.png') }}'"
                    onmouseleave="this.getElementsByTagName('img')[0].src='{{ asset('img/assets/home.png') }}'">
                    <img src="{{ asset('img/assets/home.png') }}" alt="">
                </a>
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
                        <h1>Seguidores: {{ $followers->count() }}</h1>
                        <ul>
                            @foreach ($followers as $follower)
                                <a href="{{ route('user.profile', ['id' => $follower->id]) }}" class="">
                                    <li>{{ $follower->name }}</li>
                                </a>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div id="following" class="hidden text-white tab">
                    <div>
                        <h1>Siguiendo: {{ $following->count() }}</h1>
                        <ul>
                            @foreach ($following as $followed)
                                <a href="{{ route('user.profile', ['id' => $followed->id]) }}" class="">
                                    <li>{{ $followed->name }}</li>
                                </a>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div id="albums" class="hidden text-white tab">
                    <div>
                        @if (Auth::check() && (Auth::user()->id === $user->id || Auth::user()->id === 1))
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addAlbumModal">
                                Agregar Álbum
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="addAlbumModal" tabindex="-1" aria-labelledby="addAlbumModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content glass-morphism">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addAlbumModalLabel">Agregar Nuevo Álbum</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="text-white" action="{{ route('albums.store') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="">
                                                    <label for="name" class="form-label">Nombre del Álbum:</label>
                                                    <input type="text" id="name" name="name" class="form-control"
                                                        required>
                                                </div>

                                                <div class="">
                                                    <label for="image" class="form-label">Imagen del Álbum:</label>
                                                    <input type="file" id="image" name="image" class="form-control"
                                                        required>
                                                </div>

                                                <button type="submit" class="btn btn-primary">Agregar Álbum</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($albums->isEmpty())
                            <h1>No hay álbumes en este momento.</h1>
                        @else
                            @foreach ($albums as $albumId => $albumName)
                                <a href="{{ route('album.show', ['id' => $albumId]) }}" class="imagencita"
                                    style="background-color: red">
                                    <h5 behavior="" direction="left" class="album-name">{{ $albumName }}</h5>
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
