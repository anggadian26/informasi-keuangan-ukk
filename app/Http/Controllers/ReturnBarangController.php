<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualanModel;
use App\Models\PengeluaranModel;
use App\Models\PenjualanModel;
use App\Models\ProductModel;
use App\Models\ReturnBarangModel;
use App\Models\StokModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReturnBarangController extends Controller
{
    public function showData(Request $request)
    {
        $tanggal = $request->tanggal;

        $query = ReturnBarangModel::query()
            ->select('A.*', 'B.product_code', 'B.product_name', 'C.name')
            ->from('return_barang AS A')
            ->leftJoin('product AS B', 'A.product_id', '=', 'B.product_id')
            ->join('users AS C', 'A.record_id', '=', 'C.id')
            ->when($tanggal, function($query, $tanggal) {
                return $query->where('A.tanggal', '=', $tanggal);
            })
            ->orderBy('A.tanggal', 'desc');

        $return = $query->paginate(50);

        $queryCount = "
            SELECT COUNT(1) AS totalData
            FROM return_barang";

        $total = DB::select($queryCount);

        return view('return-barang.index', compact('return', 'total'));
    }

    public function cekNota(Request $request) 
    {
        $nota = $request->nota_penjualan;

        $penjualan = PenjualanModel::where('nota', $nota)->first();

        if (!$penjualan) {
            return response()->json(['error' => 'Nota not found']);
        }

        $oneMonthAgo = Carbon::now()->subMonth();
        $tanggalPenjualan = Carbon::parse($penjualan->tanggal_penjualan);

        if ($tanggalPenjualan->lessThan($oneMonthAgo)) {
            return response()->json(['error' => 'Nota is older than one month']);
        }

        $detailPenjualan = DetailPenjualanModel::where('penjualan_id', $penjualan->penjualan_id)->get();

        $productIds = $detailPenjualan->pluck('product_id')->unique()->toArray();

        $products = ProductModel::whereIn('product_id', $productIds)->get();

        $resultProducts = [];

        foreach ($productIds as $productId) {
            $matchingProduct = $products->where('product_id', $productId)->first();

            if ($matchingProduct) {
                $resultProducts[] = $matchingProduct;
            }
        }

        $resultProducts = array_values($resultProducts);

        return response()->json(['product' => $resultProducts, 'detailPenjualan' => $detailPenjualan, 'penjualan' =>$penjualan]); 

    }

    public function returnAction(Request $request) 
    {
        $val = $request->validate([
            'nota'          => 'required',
            'product_id'    => 'required',
            'jumlah_return' => 'required',
            'detail_penjualan_id'   => 'required'
        ]);

        $nota_penjualan = intval($val['nota']);
        $product_id = intval($val['product_id']);
        $jumlah_return = intval($val['jumlah_return']);
        $detail_penjualan_id = intval($val['detail_penjualan_id']);

        $data = [
            'tanggal' => Carbon::now()->toDateString(),
            'nota_penjualan'    => $nota_penjualan,
            'product_id'        => $product_id,
            'jumlah_return'     => $jumlah_return,
            'keterangan'        => $request->keterangan,
            'record_id'         => Auth::user()->id
        ];

        ReturnBarangModel::create($data);

        $detailPenjualan = DetailPenjualanModel::find($detail_penjualan_id);
        $detailPenjualan->update([
            'flg_return'    => 'Y'
        ]);

        $stok = StokModel::where('product_id', $product_id)->first();
        $stok->update([
            'total_stok'    => $stok->total_stok + $jumlah_return,
            'update_stok_date'  => Carbon::now()->toDateString()
        ]);

        $pengeluaranData = [
            'jenis_pengeluaran'     => 'L',
            'tanggal_pengeluaran'   => Carbon::now()->toDateString(),
            'total_nominal'         => $detailPenjualan->harga_diskon * $jumlah_return,
            'keterangan'            => 'Return Barang ' . $nota_penjualan 
        ];

        PengeluaranModel::create($pengeluaranData);

        return redirect()->back()->with('toast_success', 'Berhasil melakukan Return Barang!');
    }
}
