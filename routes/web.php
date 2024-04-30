<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SongController;
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

Route::get('/home', [HomeController::class, 'show'])->name('home');

/*Rutas para songs */
Route::post('/song', [SongController::class, 'store'])->name('songs.store');
Route::get('/song/{id}', [SongController::class, 'getSongById'])->name('songs.getSongById');
Route::get('/song/{id}/delete', [SongController::class, 'deleteSongById'])->name('songs.deleteSongById');

/* Rutas para albums */
Route::get("/albumForm", function(){
    return view("temp/albumForm");
});
Route::post('/album', [AlbumController::class, 'store'])->name('albums.store');
Route::get('/album/{id}', [AlbumController::class, 'getAlbumById'])->name('album.show');
Route::get('/album/{id}/update', [AlbumController::class, 'update'])->name('album.update');


/* Rutas para usuarios*/
Route::get('user_data', [UserController::class, 'seeData'])->name('user.data');
Route::get('user/{id}', [UserController::class, 'show'])->name('user.profile');
Route::post('users/{id}/follow', [UserController::class, 'follow'])->name('user.follow');
Route::post('users/{id}/unfollow', [UserController::class, 'unfollow'])->name('user.unfollow');

Route::post('profile_update', [UserController::class, 'update'])->name('user.update');
Route::get('user/profile', [UserController::class, 'edit'])->name('user.edit');

/*Rutas para search */
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::post('/search-artist', [SearchController::class, 'searchArtist'])->name('searchArtist');
