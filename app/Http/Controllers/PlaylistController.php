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
        try {
            $song = Song::findOrFail($request->input('songId'));
            $playlist = Playlist::findOrFail($request->input('playlistId'));

            if ($playlist->songs()->where('song_id', $song->id)->exists()) {
                $playlist->songs()->detach($song);
                return response()->json(['err' => false, 'message' => 'Canción eliminada de la playlist exitosamente.']);
            }

            return response()->json(['err' => true, 'message' => 'Canción no encontrada en la playlist.']);
        } catch (\Exception $e) {
            return response()->json(['err' => true, 'message' => 'Error al eliminar la canción: ' . $e->getMessage()]);
        }
    }

       public function update(Request $request)
    {
        $playlistId = $request->input('playlist_id'); // Obtener la ID de la platlist del request

        $playlist = Playlist::findOrFail($playlistId);

        if ($request->has('name') && !is_null($request->input('name'))) {
            $playlist->name = $request->input('name');
        }

        if ($request->has('description') && !is_null($request->input('description'))) {
            $playlist->description = $request->input('description');
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageFile = base64_encode(file_get_contents($image));
            $playlist->image = $imageFile;
        }

        $playlist->save();

        // Redireccionar a la ruta album.show con la ID del álbum actualizado
        return redirect()->route('playlist.show', ['id' => $playlist->id]);
    }

    public function delete(Request $request)
    {
        $playlist = Playlist::findOrFail($request->playlist_id);
        $user = auth()->user();

        $playlist->delete();

        return redirect()->route('user.profile', ['id' => $user->id])->with('success', 'Álbum eliminado exitosamente.');
    }
}
