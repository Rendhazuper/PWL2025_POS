<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransaksiController;
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
Route::get('/hello', function () {
        return view('blog.hello', ['name' => 'rendha' ]);
});
//HomeController
Route::get('/Home', [HomeController::class, 'Homepage']);
//ArticleController
Route::get('/article/{id}', [ArticleController::class, 'index']);
//AboutController
Route::get('/user/{nama}', [AboutController::class, 'nama']);


//CategoryController 
Route::get('/category', [CategoryController::class, 'category']);
//Route Grouping
Route::prefix('category')->group(function () {
    Route::get('/food-baverage', [CategoryController::class, 'foodBaverage']);
    Route::get('/beauty-health', [CategoryController::class, 'beautyHealth']);
    Route::get('/home-care', [CategoryController::class, 'homeCare']);
    Route::get('/baby-care', [CategoryController::class, 'babyCare']);
});

//TransaksiController
Route::get('/transaksi',[TransaksiController::class, 'penjualan']);