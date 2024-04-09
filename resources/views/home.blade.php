@extends('_layouts.template')

@section('title', 'home')

@section('links')
    @vite('resources/js/reproduction_panel.js')
    @vite('resources/js/home.js')
    <link rel="stylesheet" href="{{ asset('styles/style.css') }}">
@endsection

@section('content')
    <div id="home">

    </div>
@endsection
