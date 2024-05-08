<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserReproduction;
use App\Models\Song;

class UserReproductionController extends Controller
{
    /**
     * Incrementa el contador de reproducciones de una canción y registra la reproducción del usuario.
     *
     * @param  int  $songId
     * @return \Illuminate\Http\JsonResponse
     */
    public function addReproduction($songId)
    {
        try {
            $song = Song::findOrFail($songId);

            $song->reproductions += 1;
            $song->save();

            $userReproduction = UserReproduction::where('song_id', $songId)->first();

            if ($userReproduction) {
                $userReproduction->reproductions += 1;
                $userReproduction->save();
            } else {
                UserReproduction::create([
                    'user_id' => auth()->id(),
                    'song_id' => $songId,
                    'reproductions' => 1,
                ]);
            }

            return response()->json(['message' => 'Reproducción registrada correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al registrar la reproducción'], 500);
        }
    }
}
