@extends('_layouts.template')

@section('title', 'home')

@section('links')
    <link rel="stylesheet" href="{{asset("styles/welcome.css")}}">
    <script defer src="{{asset("js/userLogInRequest.js")}}"></script>
@endsection

@section('content')
    <div id="app" class="h-100">
        <div class="d-flex flex-column h-100 w-100">
            <div class="header w-100 d-flex align-items-center">
                <div class="logoContainer">
                    <img src="img/logos/logo_texto.png" alt="">
                </div>
                <div class="links d-flex">
                    <a class="color-white pointer" onclick="userLoginRequest()">Log in</a>
                    <a href="/register">Register</a>
                </div>
            </div>
            <div class="body">
                <div class="mainLogo">
                    <img src="img/logos/logo_texto.png" alt="">
                </div>
            </div>
        </div>
    </div>
@endsection
