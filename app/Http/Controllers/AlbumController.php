<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Album;
use App\Models\Song;


class AlbumController extends Controller{


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

    return view('album/show')->with('album', $album);
}

public function getAlbumById($id)
{
    $album = Album::with('songs')->find($id);

    if (!$album) {
        return view('error')->with('message', 'Canción no encontrada');
    }

    return view('album/show')->with('album', $album);
}

}
