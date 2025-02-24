<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CategoryController;

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
Route::get('/products', function() {
    return view('products');
});
Route::get('/sales', function() {
    return view('sales');
});

Route::prefix('category')->group(function () {
    Route::get('/food-beverage', [CategoryController::class, 'foodBeverage'])->name('category.food-beverage');
    Route::get('/beauty-health', [CategoryController::class, 'beautyHealth'])->name('category.beauty-health');
    Route::get('/home-care', [CategoryController::class, 'homeCare'])->name('category.home-care');
    Route::get('/baby-kid', [CategoryController::class, 'babyKid'])->name('category.baby-kid');
});
Route::get('/user/{id}/name/{name}',[UserController::class, 'user']);

