<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 

class HomeController extends Controller
{
    public function show()
    {
        $users = User::whereHas('albums')->inRandomOrder()->limit(10)->distinct()->get();

        return view("home")->with("users", $users);
    }
}
