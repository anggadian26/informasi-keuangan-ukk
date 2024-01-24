<?php

namespace App\Http\Controllers;

use App\Models\PembelianModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailPembelianController extends Controller
{
    public function transactionPage()
    {
        $pembelian_id = request()->session()->get('pembelian_id');
        $supplier_id = request()->session()->get('supplier_id');

        $supplier = SupplierModel::find($supplier_id);
        if (! $supplier) { 
            abort(404);
        }

        $queryProduk = "
            SELECT A.*, B.total_stok
            FROM product A
            INNER JOIN stok B ON A.product_id = B.product_id
            ORDER BY A.product_code, A.product_name
        ";
        $product = DB::select($queryProduk);

        return view('pembelian.transactionPage', compact(['supplier', 'product', 'pembelian_id']));
    }

    public function backTransactionPage($id)
    {
        PembelianModel::find($id)->delete();

        return redirect()->route('index.pembelian');
    }
}
