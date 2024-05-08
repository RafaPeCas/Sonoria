<?php

namespace App\Http\Controllers;

use App\Models\User; 
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function show()
    {
        $users = User::whereHas('albums')->inRandomOrder()->limit(10)->distinct()->get();
        $playlists = Auth::user()->playlists()->get(); // Obtener todas las listas de reproducción del usuario actual

        return view("home")->with("users", $users)->with("playlists",$playlists);
    }
}
