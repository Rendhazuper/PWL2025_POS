<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\StokController;
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
Route::pattern('id', '[0-9]+');
Route::get('login',[AuthController::class, 'login'])->name('login');
Route::post('login',[AuthController::class, 'postlogin']);
Route::get('logout',[AuthController::class, 'logout'])->middleware('auth');
Route::get('register',[AuthController::class, 'register']);
Route::post('/register/create',[AuthController::class, 'store']);
Route::post('logout',[AuthController::class, 'logout']);

Route::get('/phpinfo', function() {
    return phpinfo();
});

Route::get('/check-extensions', function() {
    return [
        'php_version' => PHP_VERSION,
        'php_ini' => php_ini_loaded_file(),
        'zip_loaded' => extension_loaded('zip'),
        'gd_loaded' => extension_loaded('gd'),
        'all_extensions' => get_loaded_extensions()
    ];
});

Route::middleware(['auth'])->group(function (){

    Route::middleware(['authorize:ADM,MNG'])->group(function () {
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
            Route::get('/{id}/edit', [BarangController::class, 'edit']);
            Route::put('/{id}/update', [BarangController::class, 'update']);
            Route::get('/{id}/delete', [BarangController::class, 'confirm']);
            Route::delete('/{id}/delete', [BarangController::class, 'delete']);
            Route::get('/import', [BarangController::class, 'import']);
            Route::post('/import_ajax', [BarangController::class, 'import_ajax']);
            Route::get('/export_excel', [BarangController::class, 'export_excel']);
            Route::get('/export_pdf', [BarangController::class, 'export_pdf']);
        });

        Route::prefix('supplier')->group(function () {
            Route::get('/',[supplierController::class, 'index']);
            Route::post('/list', [supplierController::class, 'list']);
            Route::get('/create',[supplierController::class, 'create']);
            Route::post('/ajax',[supplierController::class, 'store']);
            Route::get('/{id}',[supplierController::class, 'show']);
            Route::get('/{id}/edit',[supplierController::class, 'edit']);
            Route::put('/{id}/update',[supplierController::class, 'update']);
            Route::get('/{id}/delete',[supplierController::class, 'confirm']);
            Route::delete('/{id}/delete',[supplierController::class, 'delete']);
        });

        Route::prefix('stok')->group(function () {
            Route::get('/', [StokController::class, 'index']);
            Route::post('/list', [StokController::class, 'list']);
            Route::get('/create', [StokController::class, 'create']);
            Route::post('/ajax', [StokController::class, 'store']);
            Route::get('/{id}', [StokController::class, 'show']);
            Route::get('/{id}/edit', [StokController::class, 'edit']);
            Route::put('/{id}/update', [StokController::class, 'update']);
            Route::get('/{id}/delete', [StokController::class, 'confirm']);
            Route::delete('/{id}/delete', [StokController::class, 'delete']);
        });

        Route::prefix('transaksi')->group(function () {
            Route::get('/', [TransaksiController::class, 'index']);
            Route::post('/list', [TransaksiController::class, 'list']);
            Route::get('/create', [TransaksiController::class, 'create']);
            Route::post('/ajax', [TransaksiController::class, 'store']);
            // Route::get('/{id}', [TransaksiController::class, 'show']);
            Route::get('/{id}/edit', [TransaksiController::class, 'edit']);
            Route::put('/{id}/update', [TransaksiController::class, 'update']);
            Route::get('/{id}/delete', [TransaksiController::class, 'confirm']);
            Route::delete('/{id}/delete', [TransaksiController::class, 'delete']);
        });
    });

    //WelcomeController
Route::get('/', [WelcomeController::class, 'index']);
//HomeController
Route::get('/Home', [HomeController::class, 'Homepage']);
//ArticleController
Route::get('/article/{id}', [ArticleController::class, 'index']);





//TransaksiController
Route::get('/transaksi',[TransaksiController::class, 'penjualan']);


});


//Route User Grouping



