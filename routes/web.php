<?php
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
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get("/home", function(){
    return view("home");
});

Route::post('/songs', [SongController::class, 'store'])->name('songs.store');
Route::get('user_data', [UserController::class, 'seeData'])->name('user.data');

Route::post('profile_update', [UserController::class, 'update'])->name('user.update');
Route::get('user/profile', [UserController::class, 'edit'])->name('user.edit');
