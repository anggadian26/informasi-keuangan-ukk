<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\CtgrProdukController;
use App\Http\Controllers\DetailPembelianController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\SubCtgrProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UtangController;
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

    /* -- TRANSAKSI -- */
    // pembelian
    Route::get('/pembelian-data', [PembelianController::class, 'showData'])->name('index.pembelian');
    Route::get('/search-supplier', [PembelianController::class, 'searchSupplier']);
    Route::get('/transaksi-pembelian-page/{id}/create', [PembelianController::class, 'createTransaction'])->name('transactionCreate.pembelian');
    Route::get('/transaksi-pembelian-page', [DetailPembelianController::class, 'transactionPage'])->name('transactionPage.pembelian');
    Route::get('/transaction-back/{id}', [DetailPembelianController::class, 'backTransactionPage'])->name('backTransaction.pembelian');
    Route::get('/search-product-transaction', [DetailPembelianController::class, 'searchProduct']);
    Route::post('/store-detail-pembelian', [DetailPembelianController::class, 'storePembelianProduct'])->name('storePembelianProduct.pembelian');
    Route::get('/pembelian-datail-produk/{id}/data', [DetailPembelianController::class, 'data'])->name('detailProduct.pembelian');
    Route::delete('/delete-pembelian-detail/{id}', [DetailPembelianController::class, 'deleteDetailPembelian'])->name('deletePembelianProduct.pembelian');
    Route::post('/pembelian_quantity/{id}', [DetailPembelianController::class, 'update']);
    Route::post('/save-transaksi-pembelian', [PembelianController::class, 'store'])->name('saveTransaction.pembelian');
    Route::get('/pembelian-detail/{id}', [PembelianController::class, 'detailData'])->name('pembelianDetail.pembelian');

    Route::get('/penjualan-data', [PenjualanController::class, 'showData'])->name('index.penjualan');

    /* -- FINANSIAL -- */
    // utang
    Route::get('/utang-data', [UtangController::class, 'showData'])->name('index.utang');
    Route::get('/detail-utang/{id}', [UtangController::class, 'detailUtang'])->name('detail.utang');
    Route::post('/bayar-utang', [UtangController::class, 'bayarUtang'])->name('bayar.utang');

    /* -- MASTER -- */ 
    // stok
    Route::get('/stok', [StokController::class, 'showData'])->name('index.stok');

    // produk
    Route::get('/product', [ProdukController::class, 'showData'])->name('index.produk');
    Route::get('/add-product', [ProdukController::class, 'addProductPage'])->name('addPage.product');
    Route::post('/add-product-action', [ProdukController::class, 'addProductAction'])->name('addAction.product');
    Route::get('/edit-product/{id}', [ProdukController::class, 'editProductPage'])->name('editPage.product');
    Route::post('/edit-product-action/{id}', [ProdukController::class, 'editProductAction'])->name('editAction.product');
    Route::delete('/delete-product/{id}', [ProdukController::class, 'deleteProductAction'])->name('delete.product');

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

    // supplier
    Route::get('/supplier', [SupplierController::class, 'showData'])->name('index.supplier');
    Route::get('/add-supplier', [SupplierController::class, 'addSupplierPage'])->name('addPage.supplier');
    Route::post('/add-supplier-action', [SupplierController::class, 'addSupplierAction'])->name('addAction.supplier');
    Route::get('/edit-supplier/{id}', [SupplierController::class, 'editSupplierPage'])->name('editPage.supplier');
    ROute::post('/edit-supplier-action/{id}', [SupplierController::class, 'editSupplierAction'])->name('editAction.supplier');
});

