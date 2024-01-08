<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\CtgrProdukController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SubCtgrProductController;
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

Route::get('/login', [Controller::class, 'index'])->name('login');
Route::post('/login-action', [Controller::class, 'loginAction'])->name('loginAction');
Route::get('/log-out', [Controller::class, 'logOut'])->name('log-out');

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    Route::get('/product', [ProdukController::class, 'index'])->name('index.produk');

    // sub kategori produk
    Route::get('/sub-ctgr-product', [SubCtgrProductController::class, 'index'])->name('index.subCtgrProduct');

    // kategori produk
    Route::get('/ctgr-product', [CtgrProdukController::class, 'showData'])->name('index.ctgrProduct');
    Route::post('/add-ctgr-product', [CtgrProdukController::class, 'store'])->name('store.ctgrProduct');
});

