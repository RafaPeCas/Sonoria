<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        // Obtener el término de búsqueda del formulario
        $term = $request->input('term');

        // Limpiar la variable $songs antes de asignarle nuevos resultados
        unset($songs);

        // Buscar canciones que coincidan con el término de búsqueda
        $songs = Song::where('name', 'like', '%' . $term . '%')->get();

        // Pasar los resultados a la vista
        return view('search_results', ['songs' => $songs, 'term' => $term]);
    }
}
