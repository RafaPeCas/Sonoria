<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Song;
use App\Models\Genre;
use App\Models\Playlist;

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
        'image' => 'nullable|image',
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
    $fileName = $file->getClientOriginalName();

    if (!Storage::exists('canciones/' . $fileName)) {
        $file->storeAs('canciones', $fileName);
    }

    $image = $request->file('image');
    $imageName = $image->getClientOriginalName();

    if (!Storage::exists('imagenes/' . $imageName)) {
        $image->storeAs('imagenes', $imageName);
    }

     $song = Song::create([
        'file' => 'canciones/' . $fileName,
        'explicit' => $request['explicit'] ?? false,
        'active' => $request['active'] ?? true,
        'hidden' => $request['hidden'] ?? false,
        'name' => $request['name'],
        'image' => 'imagenes/' . $imageName,
        'reproductions' => $request['reproductions'] ?? 0,
        'album_id' => $request['album_id'],
    ]);



    if (isset($request['genres'])) {
        $song->genres()->attach($request['genres']);
    }

    if (isset($request['playlists'])) {
        $song->playlists()->attach($request['playlists']);
    }
    
    return redirect()->back();
}

}
