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

    // produk
    Route::get('/product', [ProdukController::class, 'index'])->name('index.produk');
    Route::get('/add-product', [ProdukController::class, 'addProductPage'])->name('editPage.product');

    // sub kategori produk
    Route::get('/sub-ctgr-product', [SubCtgrProductController::class, 'showData'])->name('index.subCtgrProduct');
    Route::post('/add-sub-ctgr-product', [SubCtgrProductController::class, 'store'])->name('store.subCtgrProduct');
    Route::post('/edit-sub-ctgr-product/{id}', [SubCtgrProductController::class, 'editSubCtgr'])->name('edit.subCtgrProduct');
    Route::delete('/delete-sub-ctgr-product/{id}', [SubCtgrProductController::class, 'deleteDataSubCtgr'])->name('delete.subCtgrProduct');

    // kategori produk
    Route::get('/ctgr-product', [CtgrProdukController::class, 'showData'])->name('index.ctgrProduct');
    Route::post('/add-ctgr-product', [CtgrProdukController::class, 'store'])->name('store.ctgrProduct');
    Route::post('/edit-ctgr-product/{id}', [CtgrProdukController::class, 'updateDataCtgr'])->name('edit.ctgrProduct');
    Route::delete('/delete-ctgr-product/{id}', [CtgrProdukController::class, 'deleteDataCtgr'])->name('delete.ctgrProduct');
});

