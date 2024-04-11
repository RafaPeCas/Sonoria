@extends('auth.template')

@section('content')
<div class="container log">

     <div class="img-fluid  space "><img   src="img/logos/logo_texto.png" alt="Foto del logo AAI Systems" height="100" ></div>
    <div class="row justify-content-center">
        <div class="col-md-8 presentation shadow border">

         
                        
                <div class="borde border-0 text-center display-4"><h2>{{ __('BIENVENIDO A SONORIA') }}</h2></div>
               

               
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row mb-3 justify-content-center ">
                           

                            <div class="col-md-6">
                                <input id="email" placeholder="Email" type="email" class=" custom-input form-control @error('email') is-invalid @enderror  " name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3 justify-content-center">
                           

                            <div class="col-md-6">
                                <input id="password" type="password" placeholder="Contraseña" class=" custom-input form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3 justify-content-center">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                    
                            <button type="submit" class="  btn btn-warning  shadow-sm p-2">
                                    {{ __('Acceder') }}
                                </button>

                            
                        </div>
                        <div class="text-center mt-3">
                        @if (Route::has('password.request'))
                                    <a class="btn btn-link " href="{{ route('password.request') }}">
                                        {{ __('¿Olvidaste tu contraseña?') }}
                                    </a>
                                @endif</div>
                    </form>
                
        </div>
    </div>
</div>
@endsection
