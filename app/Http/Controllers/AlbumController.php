<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Album;

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

    return view('temp/showAlbum')->with('album', $album);
}

public function getAlbumById($id)
{
    $album = Album::find($id);

    if (!$album) {
        return view('error')->with('message', 'Canción no encontrada');
    }

    return view('temp/showAlbum')->with('album', $album);
}

}
