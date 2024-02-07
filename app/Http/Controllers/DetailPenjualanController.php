<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualanModel;
use App\Models\PenjualanModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailPenjualanController extends Controller
{
    public function index()
    {
        $penjualan_id = request()->session()->get('penjualan_id');

        $queryProduk = "
            SELECT A.*, B.total_stok
            FROM product A
            INNER JOIN stok B ON A.product_id = B.product_id
            ORDER BY A.product_code, A.product_name
        ";
        $product = DB::select($queryProduk);

        if($penjualan_id) {
            return view("penjualan.transactionPage", compact('product', 'penjualan_id'));
        }
    }

    public function backTransaction($id) 
    {
        PenjualanModel::find($id)->delete();
        DetailPenjualanModel::where('penjualan_id', $id)->delete();

        return redirect()->route('index.penjualan');
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

    public function storePenjualanProduct(Request $request)
    {
        $product = ProductModel::where('product_id', $request->product_id)->first();

        if( !$product ) {
            return response()->json('Data gagal ditambahkan', 400);
        }
        
        $detail = new DetailPenjualanModel;
        $detail->penjualan_id   = $request->penjualan_id;
        $detail->product_id     = $request->product_id;
        $detail->harga_jual     = $product->product_price;
        $detail->harga_diskon   = $product->product_price - ($product->product_price * $product->diskon / 100);
        $detail->jumlah         = 1;
        $detail->diskon         = $product->diskon;
        $subtotal = ($product->product_price - ($product->product_price * $product->diskon / 100)) * $detail->jumlah;
        $detail->sub_total      = $subtotal;
        $detail->flg_return     = 'N';
        $detail->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    public function data($id) 
    {     
        $detail = DetailPenjualanModel::with('produk.stok')->where('penjualan_id', $id)->get();
        return response()->json(['detail' => $detail]);
        // return $detail;
    }

    public function updateQty(Request $request, $id)
    {
        $detail = DetailPenjualanModel::find($id);
        $detail->jumlah = $request->jumlah;
        $detail->sub_total = $detail->harga_diskon * $request->jumlah;
        $detail->update();

        return response(null, 204);
    }

    public function deleteDetailPenjualan($id)
    {
        $detail = DetailPenjualanModel::find($id)->delete();

        return response(null, 204);
    }
}
