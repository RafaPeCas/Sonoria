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
                <div>
                    <img src="{{ asset('img/userPictures/default.png') }}" alt="" class="userIcon">
                </div>
            </div>
            <div class="contentBody">
                <div class="d-flex flex-column gap-5">
                    <div>
                        <h1>Tus mixes</h1>
                        <hr>
                    </div>

                    <div class="d-flex gap-5">
                        <button class="mixButton">

                        </button>
                        <button class="mixButton">

                        </button>
                        <button class="mixButton">

                        </button>
                        <button class="mixButton">

                        </button>
                        <button class="mixButton">

                        </button>
                    </div>
                    <div class="d-flex gap-5">
                        <button class="mixButton">

                        </button>
                        <button class="mixButton">

                        </button>
                        <button class="mixButton">

                        </button>
                        <button class="mixButton">

                        </button>
                        <button class="mixButton">

                        </button>
                    </div>
                </div>
            </div>
        </section>


    </div>
@endsection

@section("footer")
    @extends("user._reproductionPanel")
@endsection