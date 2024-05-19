@extends('_layouts.template')

@section('title', $user->name)
<link rel="stylesheet" href="{{ asset('styles/editProfile.css') }}">

@section('links')
@endsection

@section('content')
<div class="container d-flex justify-content-center align-items-center vh-100">

        <div class="col-md-6 presentation">
            <div class="rol">
                <h2 class="fw-light mb-4  align-items-center">Editando perfil de: {{ $user->name }}</h2>
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
                <div class="card border rounded-4 shadow">
                    <div class="card-body">
                        <form action="{{ route('user.update', $user->id) }}" method="POST">
                            @csrf
                            {{-- Cláusula para obtener un token de formulario al enviarlo --}}

                            <div class="mb-3">
                                <div class="">
                                    <img src="{{ asset('img/logos/profile-svgrepo-com.svg') }}" alt="icono perfil" class="mb-3" height="40">
                                </div>
                                <input type="text" name="name" class="form-control mb-2 custom-input" value="{{ $user->name }}"
                                    placeholder='{{ $user->name }}' autofocus>
                            </div>
                            <div class="mb-3">
                                <div class="">
                                    <img src="{{ asset('img/logos/email-svgrepo-com.svg') }}" alt="icono perfil" class="mb-3 " height="40">
                                </div>
                                <input type="text" name="email" class="form-control mb-2 custom-input" value="{{ $user->email }}"
                                    placeholder='{{ $user->email }}' autofocus>
                            </div>
                            <div class="mb-3">
                                <div class="">
                                    <img src="{{ asset('img/logos/gender-svgrepo-com.svg') }}" alt="icono perfil" class="mb-3" height="40">
                                </div>
                                <select name="gender" class="form-control mb-2 custom-input" autofocus>
                                    <option value="Masculino" @if($user->gender === 'Masculino') selected @endif>Masculino</option>
                                    <option value="Femenino" @if($user->gender === 'Femenino') selected @endif>Femenino</option>
                                    <option value="Otro" @if($user->gender === 'Otro') selected @endif>Otro</option>
                                </select>
                            </div>

                            <input type="number" name="id" value="{{ $user->id }}" hidden>
                            <div class="d-flex mt-5 justify-content-center">
                                <button class="btn btn-primary btn-block" type="submit">Guardar cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')

@endsection
