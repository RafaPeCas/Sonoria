<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playlist;
use Illuminate\Support\Facades\DB;

class PlaylistController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'visibility' => 'required|in:public,private',
            'description' => 'nullable|string|max:150',
            'image' => 'required|image',
        ]);
        $image = $request->file('image');
        $imageFile = base64_encode(file_get_contents($image));

        $playlistId = DB::table('playlists')->insertGetId([
            'name' => $request->name,
            'visibility' => $request->visibility,
            'description' => $request->description,
            'image' => $imageFile,
        ]);

        $userId = auth()->id();

        DB::table('user_playlist')->insert([
            'user_id' => $userId,
            'playlist_id' => $playlistId,
            'role' => 'Owner',
        ]);

        return redirect()->back()->with('success', '¡Playlist creada correctamente!');
    }

    public function getPlaylistById($id)
    {
        $playlist = Playlist::with('songs')->find($id);

        if (!$playlist) {
            return view('error')->with('message', 'Playlist no encontrada');
        }

        return view('playlist.show')->with('playlist', $playlist);
    }
}
