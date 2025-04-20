<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\supplierController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Models\KategoriModel;
use Illuminate\Support\Facades\Route;

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
    return ('Hello');
});

//WelcomeController
Route::get('/welcome', [WelcomeController::class, 'hello']);
//HomeController
Route::get('/Home', [HomeController::class, 'Homepage']);
//ArticleController
Route::get('/article/{id}', [ArticleController::class, 'index']);





//TransaksiController
Route::get('/transaksi',[TransaksiController::class, 'penjualan']);

//Route User Grouping
Route::prefix('user')->group(function () {
    Route::get('/',[UserController::class, 'index']);
    Route::post('/list',[UserController::class, 'list']);
    Route::get('/create_ajax',[UserController::class, 'create']);
    Route::post('/ajax',[UserController::class, 'store']);
    Route::get('/{id}',[UserController::class, 'show']);
    Route::get('/{id}/edit',[UserController::class, 'edit']);
    Route::put('/{id}/update',[UserController::class, 'update']);
    Route::get('/{id}/delete',[UserController::class, 'confirm']);
    Route::delete('/{id}/delete',[UserController::class, 'delete']);
});

Route::prefix('level')->group(function () {
    Route::get('/',[LevelController::class, 'index']);
    Route::post('/list',[LevelController::class, 'list']);
    Route::get('/create',[UserController::class, 'create']);
    Route::post('/',[UserController::class, 'store']);
    Route::get('/{id}',[UserController::class, 'show']);
    Route::get('/{id}/edit',[UserController::class, 'edit']);
    Route::put('/{id}',[UserController::class, 'update']);
    Route::delete('/{id}',[UserController::class, 'destroy']);
});

Route::prefix('kategori')->group(function () {
    Route::get ('/',[KategoriController::class,'index']);
    Route::post('/list', [KategoriController::class, 'list']);
    Route::get('/create',[UserController::class, 'create']);
    Route::post('/',[UserController::class, 'store']);
    Route::get('/{id}',[UserController::class, 'show']);
    Route::get('/{id}/edit',[UserController::class, 'edit']);
    Route::put('/{id}',[UserController::class, 'update']);
    Route::delete('/{id}',[UserController::class, 'destroy']);
});

Route::prefix('barang')->group(function () {
    Route::get('/', [BarangController::class, 'index']);
    Route::post('/list', [BarangController::class, 'list']);
    Route::get('/create', [BarangController::class, 'create']);
    Route::post('/', [BarangController::class, 'store']);
    Route::get('/{id}', [BarangController::class, 'show']);
    Route::get('/{id}/edit', [BarangController::class, 'edit']);
    Route::put('/{id}', [BarangController::class, 'update']);
    Route::delete('/{id}', [BarangController::class, 'destroy']);
});

Route::get('/insert', [supplierController::class, 'insert']);
Route::prefix('supplier')->group(function () {
    Route::get('/', [supplierController::class, 'index']);
    Route::post('/list', [SupplierController::class, 'list']);
    Route::get('/create', [SupplierController::class, 'create']);
    Route::post('/', [SupplierController::class, 'store']);
    Route::get('/{id}', [SupplierController::class, 'show']);
    Route::get('/{id}/edit', [SupplierController::class, 'edit']);
    Route::put('/{id}', [SupplierController::class, 'update']);
    Route::delete('/{id}', [SupplierController::class, 'destroy']);
});

