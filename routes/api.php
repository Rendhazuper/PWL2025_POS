<?php

use App\Http\Controllers\API\LvelController;
use App\Http\Controllers\API\RegisterController;
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
