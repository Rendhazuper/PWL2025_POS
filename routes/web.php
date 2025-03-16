<?php

use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/',function(){
    return view('welcome');
});

Route::get('/level', [LevelController::class,'index']);
Route::get('/kategori', [KategoriController::class,'index']);

// khusus user
Route::get('/user', [UserController::class,'index']);
Route::group(['prefix' => 'user'], function(){
    Route::get('/', [UserController::class,'index']);
    Route::post('/list', [UserController::class,'list']);
    Route::get('/create', [UserController::class,'create']);
    Route::post('/', [UserController::class,'store']);
    Route::get('/{id}', [UserController::class,'show']);
    Route::get('/{id}/edit', [UserController::class,'edit']);
    Route::put('/{id}', [UserController::class,'update']);
    Route::delete('/{id}', [UserController::class,'destroy']);
});
//Khusus kategori
Route::group(['prefix' => 'kategori'], function(){
    Route::get('/', [KategoriController::class,'index']);
    Route::post('/list', [KategoriController::class,'list']);
    Route::get('/create', [KategoriController::class,'create']);
    Route::post('/', [KategoriController::class,'store']);
    Route::get('/{id}', [KategoriController::class,'show']);
    Route::get('/{id}/edit', [KategoriController::class,'edit']);
    Route::put('/{id}', [KategoriController::class,'update']);
    Route::delete('/{id}', [KategoriController::class,'destroy']);
});
// khusus level
Route::group(['prefix' => 'level'], function(){
    Route::get('/', [LevelController::class,'index']);
    Route::post('/list', [LevelController::class,'list']);
    Route::get('/create', [LevelController::class,'create']);
    Route::post('/', [LevelController::class,'store']);
    Route::get('/{id}', [LevelController::class,'show']);
    Route::get('/{id}/edit', [LevelController::class,'edit']);
    Route::put('/{id}', [LevelController::class,'update']);
    Route::delete('/{id}', [LevelController::class,'destroy']);
});
Route::get('/', [WelcomeController::class,'index']);
