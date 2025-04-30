<?php

use App\Http\Controllers\API\BarangController;
use App\Http\Controllers\API\LvelController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\KategoriController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register',App\Http\Controllers\API\RegisterController::class)->name('register');
Route::post('/login',App\Http\Controllers\API\LoginController::class)->name('login');
Route::post('/logout',App\Http\Controllers\API\LogoutController::class)->name('logout');


//routelevel 
Route::get('levels',[LvelController::class, 'index']);
Route::post('levels',[LvelController::class, 'store']);
Route::get('levels/{level}',[LvelController::class, 'show']);
Route::put('levels/{level}',[LvelController::class, 'update']);
Route::delete('levels/{level}',[LvelController::class, 'destroy']);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//routeUser
Route::prefix('user')->group(function () {
    Route::get('/all',[UserController::class, 'index']);
    Route::get('/{user}',[UserController::class, 'show']);
    Route::put('/{user}',[UserController::class, 'update']);
    Route::delete('/{user}',[UserController::class, 'destroy']);
});
//routeKategori
Route::post('/kategori',App\Http\Controllers\API\KategoriController::class)->name('kategori');
Route::prefix('kategori')->group(function () {
    Route::get('/all',[KategoriController::class, 'index']);
    Route::get('/{kategori}',[KategoriController::class, 'show']);
    Route::put('/{kategori}',[KategoriController::class, 'update']);
    Route::delete('/{kategori}',[KategoriController::class, 'destroy']);
});
//routeBarang
Route::post('/Barang',App\Http\Controllers\API\BarangController::class)->name('kategori');
Route::prefix('kategori')->group(function () {
    Route::get('/all',[BarangController::class, 'index']);
    Route::get('/{kategori}',[BarangController::class, 'show']);
    Route::put('/{kategori}',[BarangController::class, 'update']);
    Route::delete('/{kategori}',[BarangController::class, 'destroy']);
});
Route::get('user',[LvelController::class, 'index']);
Route::post('levels',[LvelController::class, 'store']);
Route::get('levels/{level}',[LvelController::class, 'show']);
Route::put('levels/{level}',[LvelController::class, 'update']);
Route::delete('levels/{level}',[LvelController::class, 'destroy']);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
