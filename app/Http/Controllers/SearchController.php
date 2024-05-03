<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search()
    {
        return view('temp/search_results');
    }

    public function searchArtist(Request $request)
    {
        // Obtener el término de búsqueda del formulario
        $term = $request->input('term');

        // Buscar canciones que coincidan con el término de búsqueda
        $artist = User::where('name', 'like', '%' . $term . '%')->get();

        $html = '<ul>';
        foreach ($artist as $artist) {
            $html .= '<a href="' . route('user.profile', ['id' => $artist->id]) . '" class=""><li>' . $artist->name . '</li></a>';
        }
        $html .= '</ul>';


        return $html;
    }

}
