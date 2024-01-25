<?php

namespace App\Http\Controllers;

use App\Models\DetailPembelianModel;
use App\Models\PembelianModel;
use App\Models\ProductModel;
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

    public function searchProduct(Request $request) {
        $searchTerm = $request->input('searchTerm');

        $queryProduk = "
            SELECT A.*, B.total_stok
            FROM product A
            INNER JOIN stok B ON A.product_id = B.product_id
            WHERE A.product_name LIKE :searchTerm
            ORDER BY A.product_code, A.product_name
        ";
        
        $product = DB::select($queryProduk, ['searchTerm' => "%$searchTerm%"]);

        return response()->json(['product' => $product]);
    }

    public function storePembelianProduct(Request $request) 
    {
        $product = ProductModel::where('product_id', $request->product_id)->first();

        if( !$product ) {
            return response()->json('Data gagal ditambahkan', 400);
        }

        $detail = new DetailPembelianModel;
        $detail->pembelian_id = $request->pembelian_id;
        $detail->product_id = $request->product_id;
        $detail->harga_beli = $product->product_purcase;
        $detail->harga_jual = $product->product_price;
        $detail->jumlah     = 1;
        $detail->sub_total  = $product->product_purcase;
        $detail->flg_return = 'N';
        $detail->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    public function data($id) 
    {
        $detail = DetailPembelianModel::with('produk')->where('pembelian_id', $id)->get();

        return response()->json(['detail' => $detail]);
    }

}
