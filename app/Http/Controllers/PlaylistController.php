<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playlist;

class PlaylistController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user) {
            $playlists = $user->playlists;

            return view("playlists.index", compact('playlists'));
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'visibility' => 'required|string|max:20',
            'description' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:300',
            'fav' => 'boolean',
        ]);
    
        $user = auth()->user();
    
        // Crear la nueva playlist
        $playlist = new Playlist();
        $playlist->name = $request->name;
        $playlist->visibility = $request->visibility;
        $playlist->description = $request->description;
        $playlist->image = $request->image;
        $playlist->fav = $request->has('fav');
        $playlist->save();
    
        // Asociar la playlist al usuario actual mediante la tabla pivot
        $user->playlists()->attach($playlist->id, ['role' => 'owner']); // Cambia 'owner' por el rol que desees asignar al usuario
    
        return redirect()->back()->with('success', 'Playlist creada exitosamente');
    }
}
