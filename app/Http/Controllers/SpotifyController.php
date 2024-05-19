<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpotifyController extends Controller
{
    public function getUser(){
        $user = Auth::user()->id;
        $name = Auth::user()->name;
        return view("spotify.connection", compact("user", "name"));
    }
}
