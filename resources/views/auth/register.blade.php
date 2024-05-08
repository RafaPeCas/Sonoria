@extends('auth.template')

@section('content')
<div class="container log2">
    <div class="img-fluid space2">
        <img src="img/logos/logo_texto.png" alt="Foto del logo de Sonoria" height="100">
    </div>
    <div class="row justify-content-center">
        <div class="col-md-5 presentation shadow">
            <div class="borde border-0 text-center display-4"><h2>{{ __('REGÍSTRATE') }}</h2></div>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group row  justify-content-center">
                    <div class="col-md-10 mb-1 ">
                        <input id="name" placeholder="Nombre" type="text" class=" mb-2 custom-input form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row  justify-content-center">
                    <div class="col-md-10 mb-1">
                        <input id="email" type="email" placeholder="Email" class="mb-2 custom-input form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row  justify-content-center">
                    <div class="col-md-5 mb-1 ">
                        <input id="password" type="password" placeholder="Contraseña" class=" mb-2 custom-input form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-5 ">
                        <input id="password-confirm" type="password" placeholder="Repetir Contraseña" class="custom-input form-control mb-2" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>
                <div class="form-group row  justify-content-center">
                    <div class="col-md-5 mb-1 ">
                        <input id="birthdate" type="date" placeholder="Fecha de Nacimiento" class="custom-input form-control @error('birthdate') is-invalid @enderror mb-2 " name="birthdate" value="{{ old('birthdate') }}" required autofocus style="text-align: center;">
                        @error('birthdate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-5 mb-1">
                        <select id="gender" name="gender" class="custom-input form-control @error('gender') is-invalid @enderror" required>
                            <option value="" disabled selected hidden>Género</option>
                            <option value="male">Masculino</option>
                            <option value="female">Femenino</option>
                            <option value="other">Otro</option>
                        </select>
                        @error('gender')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-10 mb-1 ">
                        <select id="role" name="role" class="custom-input form-control special @error('role') is-invalid @enderror" required>
                            <option value="" disabled selected hidden>¿Qué soy?</option>
                            <option value="user">Usuario</option>
                            <option value="artist">Artista</option>
                        </select>
                        @error('role')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
              <div class="d-flex justify-content-center ml-2">
                    <button type="submit" class="login-button rounded-circle"> <img src="{{ asset('img/assets/reproducir.png') }}" alt="boton de reproduccion"  height="50" width="50"></button>
                </div>

               
                </div>

                
            </form>
        </div>
    </div>
</div>
@endsection

