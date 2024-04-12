<?php
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SongController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SpotifyController;

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
Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::get("/home", function(){
    return view("home");
});

Route::get("/spotify", [SpotifyController::class, "spotifyCallback"])->name("spotify");

Route::post('/musica', [SongController::class, 'store'])->name('songs.store');
Route::get('/song/{id}', [SongController::class, 'getSongById'])->name('songs.getSongById');


Route::get('user_data', [UserController::class, 'seeData'])->name('user.data');

Route::post('profile_update', [UserController::class, 'update'])->name('user.update');
Route::get('user/profile', [UserController::class, 'edit'])->name('user.edit');
