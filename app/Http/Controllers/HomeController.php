<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 

class HomeController extends Controller
{
    public function show()
    {
        $users = User::inRandomOrder()->limit(10)->get();

        return view("home")->with("users", $users);
    }
}
