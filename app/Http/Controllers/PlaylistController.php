<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playlist;
use App\Models\Song;

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

        $user->playlists()->attach($playlist->id, ['role' => 'owner']);

        return redirect()->back()->with('success', 'Playlist creada exitosamente');
    }


    public function show($id, $name = null)
    {
        $playlist = Playlist::findOrFail($id);

        if ($name && $playlist->name != $name) {
            return redirect()->route('playlist.show', ['id' => $playlist->id, 'name' => $playlist->name], 301);
        }

        return view("playlists.show", compact('playlist'));
    }

    public function addSong(Request $request)
    {

        $request->validate([
            'song_id' => 'required|exists:songs,id',
            'playlist_id' => 'required|exists:playlists,id',
        ]);

        $song = Song::findOrFail($request->song_id);
        $playlist = Playlist::findOrFail($request->playlist_id);

        if ($playlist->songs()->where('song_id', $song->id)->exists()) {
            return redirect()->back()->with('error', 'La canción ya está en la playlist.');
        }

        $playlist->songs()->attach($song);

        return redirect()->back()->with('success', 'Canción agregada a la playlist exitosamente.');
    }
}
