<?php

use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;
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
    Route::get ('/create_ajax', [UserController::class,'create_ajax']);
    Route::post ('/ajax', [UserController::class,'store_ajax']);
    Route::get('/{id}', [UserController::class,'show']);
    Route::get('/{id}/edit_ajax', [UserController::class,'edit_ajax']);
    Route::put('/{id}/update_ajax', [UserController::class,'update_ajax']);
    Route::get('/{id}/delete_ajax', [UserController::class,'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [UserController::class,'delete_ajax']);
});
//Khusus kategori
Route::group(['prefix' => 'kategori'], function(){
    Route::get('/', [KategoriController::class,'index']);
    Route::post('/list', [KategoriController::class,'list']);
    Route::get('/create', [KategoriController::class,'create']);
    Route::post('/', [KategoriController::class,'store']);
    Route::get('/create_ajax', [KategoriController::class,'create_ajax']);
    Route::post('/ajax', [KategoriController::class,'store_ajax']);
    Route::get('/{id}', [KategoriController::class,'show']);
    Route::get('/{id}/edit', [KategoriController::class,'edit']);
    Route::get('/{id}/edit_ajax', [KategoriController::class,'edit_ajax']);
    Route::put('/{id}/update_ajax', [KategoriController::class,'update_ajax']);
    Route::get('/{id}/delete_ajax', [KategoriController::class,'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [KategoriController::class,'delete_ajax']);
});
// khusus level
Route::group(['prefix' => 'level'], function(){
    Route::get('/', [LevelController::class,'index']);
    Route::post('/list', [LevelController::class,'list']);
    Route::get('/create', [LevelController::class,'create']);
    Route::post('/', [LevelController::class,'store']);
    Route::get('/create_ajax', [LevelController::class,'create_ajax']);
    Route::post('/ajax', [LevelController::class,'store_ajax']);
    Route::get('/{id}', [LevelController::class,'show']);
    Route::get('/{id}/edit', [LevelController::class,'edit']);
    Route::get('/{id}/edit_ajax', [LevelController::class,'edit_ajax']);
    Route::put('/{id}/update_ajax', [LevelController::class,'update_ajax']);
    Route::get('/{id}/confirm_ajax', [LevelController::class,'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [LevelController::class,'delete_ajax']);
});

// khusus barang
Route::group(['prefix' => 'barang'], function(){
    Route::get('/', [BarangController::class,'index']);
    Route::post('/list', [BarangController::class,'list']);
    Route::get('/create', [BarangController::class,'create']);
    Route::post('/', [BarangController::class,'store']);
    Route::get('/create_ajax', [BarangController::class,'create_ajax']);
    Route::post('/ajax', [BarangController::class,'store_ajax']);
    Route::get('/{id}', [BarangController::class,'show']);
    Route::get('/{id}/edit', [BarangController::class,'edit']);
    Route::get('/{id}/show_ajax', [BarangController::class,'show_ajax']);
    Route::get('/{id}/edit_ajax', [BarangController::class,'edit_ajax']);
    Route::put('/{id}/update_ajax', [BarangController::class,'update_ajax']);
    Route::get('/{id}/delete_ajax', [BarangController::class,'delete_ajax']);
    Route::delete('/{id}/destroy_ajax', [BarangController::class,'destroy_ajax']);
});

// khusus supplier
Route::group(['prefix' => 'supplier'], function(){
    Route::get('/', [SupplierController::class,'index']);
    Route::post('/list', [SupplierController::class,'list']);
    Route::get('/create', [SupplierController::class,'create']);
    Route::post('/', [SupplierController::class,'store']);
    Route::get('/create_ajax', [SupplierController::class,'create_ajax']);
    Route::post('/ajax', [SupplierController::class,'store_ajax']);
    Route::get('/{id}', [SupplierController::class,'show']);
    Route::get('/{id}/edit', [SupplierController::class,'edit']);
    Route::get('/{id}/edit_ajax', [SupplierController::class,'edit_ajax']);
    Route::put('/{id}/update_ajax', [SupplierController::class,'update_ajax']);
    Route::get('/{id}/delete_ajax', [SupplierController::class,'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [SupplierController::class,'delete_ajax']);
});

Route::get('/', [WelcomeController::class,'index']);
