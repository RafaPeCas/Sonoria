@extends('_layouts.template')

@section('title', $user->name)

<link rel="stylesheet" href="{{ asset('styles/profile.css') }}">
<script defer src="{{ asset('js/profile.js') }}"></script>
@section('links')

@endsection

@section('content')
    <p id="userId" hidden>{{ Auth::user()->id }}</p>
    @if ($user->role === 'artist')
        <h1>Hola artista</h1>
    @else
        <div class="userHeader">
            <div class="userData">
                <div class="userImage">
                @if ($user->avatar)
                    {{-- Muestra el avatar en forma base64 si está definido --}}
                    <img src="data:image/png;base64,{{ $user->avatar }}" alt="userPicture">
                @else
                    {{-- Si no está definido, muestra la imagen por defecto --}}
                    <img src="{{ asset('img/userPictures/default.png') }}" alt="userPicture">
                @endif
                    
                    <div class="d-flex mt-3 justify-content-center">@if (Auth::check() && Auth::user()->id === $user->id)  <button type="button" class="btn followButtom" data-bs-toggle="modal" data-bs-target="#editModal">
                        Editar perfil
                    </button>@endif</div>
                    

                    
                 
                    @if (Auth::check() && Auth::user()->id !== $user->id)

                    @if ($isFollowing)
                        <form action="{{ route('user.unfollow', $user->id) }}" method="POST">
                            @csrf
                            <button class="followButtom justify-content-center follow2" type="submit">Dejar de Seguir</button>
                        </form>
                    @else
                        <form action="{{ route('user.follow', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="followButtom justify-content-center follow">Seguir</button>
                        </form>
                    @endif

                @endif
                </div>
                <div class="userName">
                    <h2>{{ $user->name }}</h2>
                    <hr>

                    <p>
                        <img src="{{asset('img/logos/email-svgrepo-com.svg')}}" alt="icono email" height="30" style="filter: invert(1);">
                        <span class="spaceIcon">{{ $user->email }}</span>
                    </p>

                    <p>
                        <img src="{{asset('img/logos/gender-svgrepo-com.svg')}}" alt="icono genero" height="34" style="filter: invert(1);">
                        <span class="mr-3">{{ trans($user->gender) }}</span>
                    </p>

                    @if($user->role)
                        <p>
                            <img src="{{asset('img/logos/profile-svgrepo-com.svg')}}" alt="icono perfil" height="36" style="filter: invert(1);">
                            <span class="spaceIcon">{{ trans($user->role->name) }}</span>
                        </p>
                    @else
                        <p>
                            <img src="{{asset('img/logos/profile-svgrepo-com.svg')}}" alt="icono perfil" height="36" style="filter: invert(1);">
                            <span class="spaceIcon">Rol no disponible</span>
                        </p>
                    @endif

                   



                </div>

           
            </div>
            <div class="mt-5 me-3 ms-3">
                <a href="{{ route('home') }}"
                    onmouseover="this.getElementsByTagName('img')[0].src='{{ asset('img/assets/homeHover.png') }}'"
                    onmouseleave="this.getElementsByTagName('img')[0].src='{{ asset('img/assets/home.png') }}'">
                    <img src="{{ asset('img/assets/home.png') }}" alt="" style="filter: invert(1);">
                </a>
            </div>
        </div>
        <div class="tabContainer">
            <div class="tabs">
                <button class="tab-button" data-tab="followers">Seguidores</button>
                <button class="tab-button" data-tab="following">Siguiendo</button>
                <button class="tab-button" data-tab="playlists">Playlists</button>
                <button class="tab-button" data-tab="albums">Álbums</button>
                @if (auth::user()->id === $user->id)
                    <button class="tab-button" data-tab="statistics">Mis datos de spotify</button>
                @endif
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
                <div id="playlists" class="hidden text-white tab">
                    <div>
                        @if (Auth::check() && (Auth::user()->id === $user->id || Auth::user()->id === 1))
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary mt-3 mb-3" data-bs-toggle="modal"
                                data-bs-target="#addPlaylistModal">
                                Agregar PLaylist
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="addPlaylistModal" tabindex="-1" aria-labelledby="addPlaylistModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content glass-morphism">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addPlaylistModalLabel">Agregar Nuevo Álbum</h5>
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

                                                <button type="submit" class="btn btn-primary">Create Playlist</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (empty($user->playlists))
                            <h1>No hay álbumes en este momento.</h1>
                        @else
                            @foreach ($user->playlists as $playlist)
                                <a href="{{ route('playlist.show', ['id' => $playlist['id']]) }}"
                                    class="imagencita link-no-style mt-3 mb-3">
                                    @if (!empty($playlist['image']))
                                        <img src="data:image/jpeg;base64,{{ $playlist['image'] }}" alt="{{ $playlist['name'] }}"
                                            class="bigAlbumImage mt-3 mb-3">
                                    @else
                                        <img src="{{ asset('img/cover/test.jpg') }}" alt="{{ $playlist['name'] }}"
                                            class="bigAlbumImage mt-3 mb-3">
                                    @endif
                                    <h3 behavior="" direction="left" class="album-name">{{ $playlist['name'] }}</h3>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div id="albums" class="hidden text-white tab">
                    <div>
                        @if (Auth::check() && (Auth::user()->id === $user->id || Auth::user()->id === 1))
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary mt-3 mb-3" data-bs-toggle="modal"
                                data-bs-target="#addAlbumModal">
                                Agregar Álbum
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="addAlbumModal" tabindex="-1"
                                aria-labelledby="addAlbumModalLabel" aria-hidden="true">
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
                                                    <input type="text" id="name" name="name"
                                                        class="form-control" required>
                                                </div>

                                                <div class="">
                                                    <label for="image" class="form-label">Imagen del Álbum:</label>
                                                    <input type="file" id="image" name="image"
                                                        class="form-control" required>
                                                </div>

                                                <button type="submit" class="btn btn-primary">Agregar Álbum</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (empty($albums))
                            <h1>No hay álbumes en este momento.</h1>
                        @else
                            @foreach ($albums as $album)
                                <a href="{{ route('album.show', ['id' => $album['id']]) }}"
                                    class="imagencita link-no-style mt-3 mb-3">
                                    @if (!empty($album['image']))
                                        <img src="data:image/jpeg;base64,{{ $album['image'] }}"
                                            alt="{{ $album['name'] }}" class="bigAlbumImage mt-3 mb-3">
                                    @else
                                        <img src="{{ asset('img/cover/test.jpg') }}" alt="{{ $album['name'] }}"
                                            class="bigAlbumImage mt-3 mb-3">
                                    @endif
                                    <h3 behavior="" direction="left" class="album-name">{{ $album['name'] }}</h3>
                                </a>
                            @endforeach
                        @endif


                    </div>
                </div>
                @if (auth::user()->id === $user->id)
                    <div id="statistics" class="hidden tab text-white">
                        <div>
                            <div id="sData" hidden>
                                <p class="trigger" hidden></p>
                                <h1>Nombre de usuario en Spotify</h1>
                                <h3 id="sName"></h3>

                                <h1>Región</h1>
                                <h3 id="sCountry"></h3>

                                <h1>Correo asociado</h1>
                                <h3 id="sEmail"></h3>

                                <h1>Filtro de contenido explicito</h1>
                                <h3 id="sExplicit"></h3>

                                <a id="sProfile" target="_blank">Link a tu perfil</a>

                                <h1>Seguidores</h1>
                                <h3 id="sFollowers"></h3>

                                <h1>Id de tu cuenta</h1>
                                <h3 id="sId"></h3>

                                <h1>Imágen de tu perfil</h1>
                                <img id="sImage"></img>

                                <h1>Tipo de cuenta</h1>
                                <h3 id="sPremium"></h3>

                                <h1>Tipo de usuario</h1>
                                <h3 id="sType"></h3>

                                <a id="sUri">Abrir tu aplicación localmente</a>

                                
                            </div>
                            <div id="SpotifyNotConnected" hidden>
                                <a href="{{ route('spotify') }}">Conectar con Spotify</a>
                            </div>
                            <script>
    if (localStorage.getItem("user") && localStorage.getItem("userId") == document.querySelector("#userId").innerHTML) {
        document.querySelector("#sData").removeAttribute("hidden")

        const userInfo = JSON.parse(localStorage.getItem("user"));
        document.querySelector("#sName").innerHTML = userInfo.display_name;
        document.querySelector("#sCountry").innerHTML = userInfo.country;
        document.querySelector("#sEmail").innerHTML = userInfo.email;
        document.querySelector("#sExplicit").innerHTML = userInfo.explicit_content.filter_enabled ? "Activado" : "Desactivado";
        document.querySelector("#sProfile").setAttribute("href", userInfo.external_urls.spotify);
        document.querySelector("#sFollowers").innerHTML = userInfo.followers.total;
        document.querySelector("#sid").innerHTML = userInfo.id;
        if (userInfo.images && userInfo.images.length > 0 && userInfo.images[0].url) {
    document.querySelector("#sImage").setAttribute("src", userInfo.images[0].url);
}
        document.querySelector("#sPremium").innerHTML = userInfo.product;
        document.querySelector("#sType").innerHTML = userInfo.type;
        document.querySelector("#sUri").setAttribute("href", userInfo.uri);
    } else {
        document.querySelector("#SpotifyNotConnected").removeAttribute("hidden")
    }
</script>

                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="addSongModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content glass-morphism">
                <div class="modal-header">
                    <h2 class="fw-light   name align-items-center">Editando perfil de: {{ $user->name }}</h2>
                    
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                 
                    <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- Cláusula para obtener un token de formulario al enviarlo --}}
                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                         @endif
                
                        <div class="mb-3">
                            <div class="d-flex">
                                <img src="{{ asset('img/logos/profile-svgrepo-com.svg') }}" alt="icono perfil" class="mb-3" height="40" style="filter: invert(1);">
                                <h3 class="ms-3">Nombre</h3>
                            </div>
                            <input type="text" name="name" class="form-control mb-2 custom-input" value="{{ $user->name }}"
                                placeholder='{{ $user->name }}' autofocus>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex">
                                <img src="{{ asset('img/logos/email-svgrepo-com.svg') }}" alt="icono perfil" class="mb-3 " height="40" style="filter: invert(1);">
                                <h3 class="ms-3">Email</h3>

                            </div>
                            <input type="text" name="email" class="form-control mb-2 custom-input" value="{{ $user->email }}"
                                placeholder='{{ $user->email }}' autofocus>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex">
                                <img src="{{ asset('img/logos/gender-svgrepo-com.svg') }}" alt="icono perfil"  height="40" class="mb-3" style="filter: invert(1);">
                                <h3 class="ms-3">Género</h3>
                            </div>
                            <select name="gender" class="form-control mb-2 custom-input" class="mb-3" autofocus>
                                <option value="Masculino" @if($user->gender === 'Masculino') selected @endif>Masculino</option>
                                <option value="Femenino" @if($user->gender === 'Femenino') selected @endif>Femenino</option>
                                <option value="Otro" @if($user->gender === 'Otro') selected @endif>Otro</option>
                            </select>
                        </div>
    
                        <div class="mb-3">
                            <div class="d-flex">
                                <img src="{{ asset('img/logos/profileImage-svgrepo-com.svg') }}" alt="icono perfil" class="mb-3 " height="38" style="filter: invert(1);">
                                <h3 class="ms-3">Avatar</h3>
                            </div>
                            <input type="file" name="image" class="form-control mb-2 custom-input" accept="image/*">
                        </div>
    
                        <input type="number" name="id" value="{{ $user->id }}" hidden>
                        <div class="d-flex mt-5 justify-content-center">
                            <button class="btn followButtom" type="submit">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

@endsection

@section('footer')

@endsection
