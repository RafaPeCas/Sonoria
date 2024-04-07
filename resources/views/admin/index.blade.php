@extends("_layouts.template")

@section("title", "Index de admin")

@section("links")
    @vite("resources/js/show_song.js")
@endsection

@section("content")
    <h1>Esta es la página de administrador</h1>
    <div id="show_song">

    </div>
@endsection