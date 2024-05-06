<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Album;
use App\Models\Song;


class AlbumController extends Controller
{


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'required|image',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $image = $request->file('image');
        $imageFile = base64_encode(file_get_contents($image));


        $userId = auth()->id() ?? 1;

        $album = Album::create([
            'name' => $request['name'],
            'image' => $imageFile,
            'user_id' => $userId,

        ]);

        $totalSongs = 0;

        return view('album.show', compact('album', 'totalSongs'));
    }


    public function getAlbumById($id)
    {
        $album = Album::with('songs')->find($id);

        if (!$album) {
            return view('error')->with('message', 'Álbum no encontrado');
        }

        $totalSongs = $album->songs->count();

        return view('album.show', compact('album', 'totalSongs'));
    }

    public function update(Request $request)
    {
        $albumId = $request->input('album_id'); // Obtener la ID del álbum del request

        $album = Album::findOrFail($albumId);

        if ($request->has('name') && !is_null($request->input('name'))) {
            $album->name = $request->input('name');
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageFile = base64_encode(file_get_contents($image));
            $album->image = $imageFile;
        }

        $album->save();

        // Redireccionar a la ruta album.show con la ID del álbum actualizado
        return redirect()->route('album.show', ['id' => $album->id]);
    }


    public function delete(Request $request)
    {
        $album = Album::findOrFail($request->album_id);
        $user = $album->user;

        $album->delete();

        return redirect()->route('user.profile', ['id' => $user->id])->with('success', 'Álbum eliminado exitosamente.');
    }

}

