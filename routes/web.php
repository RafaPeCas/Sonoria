<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\PlaylistController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
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

Route::get("/admin", function(){
    return view("admin.index");
});
Route::post('/searchSong', [SearchController::class, 'searchSong'])->name('searchSong');

Route::get("/search", function(){
    return view("temp.search_results");
});
Route::get("/home", function(){
    return view("home");
});
/*Rutas para songs */
Route::post('/song', [SongController::class, 'store'])->name('songs.store');
Route::get('/song/{id}', [SongController::class, 'getSongById'])->name('songs.getSongById');

/* Rutas para albums */
Route::get("/albumForm", function(){
    return view("temp/albumForm");
});
Route::post('/album', [AlbumController::class, 'store'])->name('albums.store');
Route::get('/album/{id}', [AlbumController::class, 'getAlbumById'])->name('albums.getAlbumById');

/* Rutas para playlist */
Route::post('/playlists', [PlaylistController::class, 'store'])->name('playlist.store');
Route::get('/playlists/{id}', [PlaylistController::class, 'getPlaylistById'])->name('playlist.getPlaylistById');


/* Rutas para usuarios*/
Route::get('user_data', [UserController::class, 'seeData'])->name('user.data');

Route::post('profile_update', [UserController::class, 'update'])->name('user.update');
Route::get('user/profile', [UserController::class, 'edit'])->name('user.edit');
