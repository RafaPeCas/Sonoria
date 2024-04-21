<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchSong(Request $request)
    {
        // Obtener el término de búsqueda del formulario
        $term = $request->input('term');

        // Buscar canciones que coincidan con el término de búsqueda
        $songs = Song::where('name', 'like', '%' . $term . '%')->get();

        // Devolver los resultados en formato HTML
        $html = '<ul>';
        foreach ($songs as $song) {
            $html .= '<li>' . $song->name . '</li>';
        }
        $html .= '</ul>';

        return $html;
    }

}
