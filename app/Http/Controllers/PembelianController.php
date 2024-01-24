<?php

namespace App\Http\Controllers;

use App\Models\PembelianModel;
use App\Models\SupplierModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function showData(Request $request)
    {
        $supplier = SupplierModel::all();
        return view('pembelian.index', compact('supplier'));
    }

    public function searchSupplier(Request $request)
    {
        $searchTerm = $request->input('searchTerm');

        $supplier = SupplierModel::where('supplier_name', 'like', "%$searchTerm%")
            ->get();

        return response()->json(['supplier' => $supplier]);
    }

    public function transactionPage($id)
    {
        $supplier = SupplierModel::find($id);

        $queryProduk = "
            SELECT A.*, B.total_stok
            FROM product A
            INNER JOIN stok B ON A.product_id = B.product_id
            ORDER BY A.product_code, A.product_name
        ";
        $product = DB::select($queryProduk);

        return view('pembelian.transactionPage', compact('supplier', 'product'));
    }
}
