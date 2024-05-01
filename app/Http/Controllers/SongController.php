<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Song;
use App\Models\Genre;
use App\Models\Playlist;
use Illuminate\Support\Facades\Redirect;

class SongController extends Controller
{
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'file' => 'required|file',
        'explicit' => 'boolean',
        'active' => 'boolean',
        'hidden' => 'boolean',
        'name' => 'required|string|max:255',
        'reproductions' => 'integer|min:0',
        'album_id' => 'required|exists:albums,id',
        'genres' => 'array',
        'genres.*' => 'exists:genres,id',
        'playlists' => 'array',
        'playlists.*' => 'exists:playlists,id',
    ]);


    if ($validator->fails()) {
        return redirect()->back()->withInput()->withErrors($validator);
    }

    $file = $request->file('file');
    $songFile = base64_encode(file_get_contents($file));




     $song = Song::create([
        'file' => $songFile,
        'explicit' => $request['explicit'] ?? false,
        'active' => $request['active'] ?? true,
        'hidden' => $request['hidden'] ?? false,
        'name' => $request['name'],
        'reproductions' => $request['reproductions'] ?? 0,
        'album_id' => $request['album_id'],
    ]);



    if (isset($request['genres'])) {
        $song->genres()->attach($request['genres']);
    }

    if (isset($request['playlists'])) {
        $song->playlists()->attach($request['playlists']);
    }

    return Redirect::route('album.show', ['id' => $request['album_id']]);
}



public function getSongById($id)
{
    $song = Song::find($id);

    if (!$song) {
        return view('error')->with('message', 'Canción no encontrada');
    }

    return view('temp/cancion')->with('song', $song);
}

public function deleteSongById($id){
    $song = Song::find($id);

    if (!$song) {
        return response()->json(['err' => true, 'message' => 'Canción no encontrada']);
    }

    try {
        $song->delete();
        return response()->json(['err' => false]);
    } catch (\Exception $e) {
        return response()->json(['err' => true, 'message' => 'Error al eliminar la canción: ' . $e->getMessage()]);
    }
}

}
