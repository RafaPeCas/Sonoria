<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SongController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserReproductionController;
use App\Http\Controllers\PlaylistController;
use App\Models\Playlist;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get("/admin", function () {
    return view("admin.index");
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'show'])->name('home');

    /*Rutas para songs */
    Route::post('/song', [SongController::class, 'store'])->name('songs.store');
    Route::get('/song/{id}', [SongController::class, 'getSongById'])->name('songs.getSongById');
    Route::get('/song/{id}/delete', [SongController::class, 'deleteSongById'])->name('songs.deleteSongById');

    /* Rutas para albums */
    Route::get("/albumForm", function () {
        return view("temp/albumForm");
    });
    Route::post('/album', [AlbumController::class, 'store'])->name('albums.store');
    Route::get('/album/{id}', [AlbumController::class, 'getAlbumById'])->name('album.show');
    Route::post('/album/update', [AlbumController::class, 'update'])->name('albums.update');
    Route::post('/album/delete', [AlbumController::class, 'delete'])->name('albums.delete');


    /* Rutas para usuarios*/
    Route::get('user_data', [UserController::class, 'seeData'])->name('user.data');
    Route::get('user/{id}', [UserController::class, 'show'])->name('user.profile');
    Route::post('users/{id}/follow', [UserController::class, 'follow'])->name('user.follow');
    Route::post('users/{id}/unfollow', [UserController::class, 'unfollow'])->name('user.unfollow');

    Route::post('profile_update', [UserController::class, 'update'])->name('user.update');
    Route::get('user/profile', [UserController::class, 'edit'])->name('user.edit');
    Route::get("personal/profile", [UserController::class, "view"])->name("profile");

    /*Rutas para search */
    Route::get('/search', [SearchController::class, 'search'])->name('search');
    Route::post('/search-artist', [SearchController::class, 'searchArtist'])->name('searchArtist');

    /*Ruta para las reproducciones */
    Route::post('/song/{songId}/reproduction', [UserReproductionController::class, 'addReproduction'])->name('song.addReproduction');

    /*Ruta para las playlists */
    Route::get("/playlists", [PlaylistController::class, "index"])->name("playlist.index");
    Route::post("/playlists/store", [PlaylistController::class, "store"])->name("playlist.store");
    Route::get("/playlists/{id}/{name?}", [PlaylistController::class, "show"])->name("playlist.show");
    Route::post('/playlist/add-song', [PlaylistController::class, 'addSong'])->name('playlist.addSong');
});

Route::get('/spotify', function () {
    return view('spotify.connection');
})->name("spotify");
