<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SpotifyController extends Controller
{
    public function spotifyCallback(Request $request)
    {
        // Obtener el código de autorización de la URL de redirección
        $code = $request->query('code');

        // Intercambiar el código de autorización por un token de acceso
        $response = (new Client)->post('https://accounts.spotify.com/api/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => 'http://localhost:8000/spotify', // Debes coincidir con el redirect_uri configurado en Spotify
                'client_id' => 'e1ccac91ae2f4f3c8534f5f9b00d729c',
                'client_secret' => '5ddc9a90685a4338894843e0ab5e9e5c',

            ],
        ]);

        $accessToken = json_decode((string) $response->getBody(), true)['access_token'];

        // Ahora tienes el $accessToken, puedes usarlo para hacer solicitudes a la API de Spotify
        // Por ejemplo, obtener información del perfil del usuario
        $profile = (new Client)->get('https://api.spotify.com/v1/me', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ],
        ]);

        $userData = json_decode((string) $profile->getBody(), true);

        // Haz lo que necesites con los datos del usuario (por ejemplo, pasarlos a la vista)
        return view('temp.spotify')->with('userData', $userData);
    }
}
