@extends('_layouts.template')

@section('content')
    <div class="container mt-5">


        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Añadir Playlist</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('playlist.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="visibility" class="form-label">Visibilidad:</label>
                                <select class="form-select" id="visibility" name="visibility" required>
                                    <option value="public">Pública</option>
                                    <option value="private">Privada</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Descripción:</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Imagen:</label>
                                <input type="file" class="form-control" id="image" name="image">
                            </div>
                            <!-- Botón para enviar el formulario -->
                            <button type="submit" class="btn btn-primary">Crear Playlist</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <h2 class="fw-light mb-5 text-white">Tu perfil: {{ $user->name }}</h2>

        <div class="card border rounded-4 shadow">
            <div class="card-body">
                <div class="row d-flex mt-5">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <p class="text-center">{{ $user->name }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <p class="text-center">{{ $user->email }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <p class="text-center">{{ $user->gender ?: 'No disponible' }}</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex mt-5 justify-content-center">
                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary">Editar perfil</a>
                </div>
            </div>
        </div>


        <!-- Sección para mostrar las playlists del usuario -->
        <div class="mt-5">

            <!-- Botón para abrir el modal -->
            <div class="row">
                <div class="col text-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Añadir Playlist
                    </button>
                </div>
            </div>

            <h3 class="fw-light mb-3 text-white">Tus playlists:</h3>
            <ul class="list-group">
                @forelse ($playlists as $playlist)
                    <li class="list-group-item">
                        <a href="{{ route('playlist.getPlaylistById', $playlist->id) }}">{{ $playlist->name }}</a>
                    </li>
                @empty
                    <li class="list-group-item">No tienes playlists aún.</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
