<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'visibility' => 'required|string|max:20',
            'description' => 'nullable|string|max:150',
            'image' => 'required|image',
        ]);

        if ($validator->fails()) {
            dd($validator->errors());
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageFile = base64_encode(file_get_contents($image));
        }

        $user = auth()->user();

        $playlist = new Playlist();
        $playlist->name = $request->name;
        $playlist->visibility = $request->visibility;
        $playlist->description = $request->description;
        $playlist->image = $imageFile;
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
        $song = Song::findOrFail($request->input('songId'));
        $playlist = Playlist::findOrFail($request->input('playlistId'));

        if ($playlist->songs()->where('song_id', $song->id)->exists()) {
            return redirect()->back()->with('error', 'La canción ya está en la playlist.');
        }

        $playlist->songs()->attach($song);

        return redirect()->back()->with('success', 'Canción agregada a la playlist exitosamente.');
    }

    public function removeSong(Request $request)
    {
        $song = Song::findOrFail($request->input('songId'));
        $playlist = Playlist::findOrFail($request->input('playlistId'));

        if ($playlist->songs()->where('song_id', $song->id)->exists()) {
            $playlist->songs()->detach($song);
            return redirect()->back()->with('success', 'Canción agregada a la playlist exitosamente.');
        }

        return redirect()->back()->with('error', 'Canción no encontrada');
    }
}
