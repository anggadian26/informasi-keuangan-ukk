<?php

namespace App\Http\Controllers;

use App\Models\DetailPembelianModel;
use App\Models\PembelianModel;
use App\Models\ProductModel;
use App\Models\StokModel;
use App\Models\SupplierModel;
use App\Models\UtangModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function showData(Request $request)
    {
        $supplier = SupplierModel::all();

        $pembelians = PembelianModel::with('supplier', 'details.product');

        // Filter berdasarkan tanggal pembelian
        if ($request->has('tanggal_pembelian')) {
            $pembelians->where('tanggal_pembelian', $request->tanggal_pembelian);
        }

        // Filter berdasarkan ID supplier
        if ($request->has('supplier_id')) {
            $pembelians->whereHas('supplier', function ($query) use ($request) {
                $query->where('supplier_id', $request->supplier_id);
            });
        }

        // Filter berdasarkan jenis pembelian
        if ($request->has('jenis_pembelian')) {
            $pembelians->where('jenis_pembelian', $request->jenis_pembelian);
        }

        $data = $pembelians->paginate(30);

        $queryCount = "
            SELECT COUNT(1) AS totalData
            FROM pembelian";

        $total = DB::select($queryCount);
        
        // return response()->json($data);
        return view('pembelian.index', compact('supplier', 'data', 'total'));
    }

    public function searchSupplier(Request $request)
    {
        $searchTerm = $request->input('searchTerm');

        $supplier = SupplierModel::where('supplier_name', 'like', "%$searchTerm%")
            ->get();

        return response()->json(['supplier' => $supplier]);
    }

    public function createTransaction($id)
    {

        $pembelian = new PembelianModel();
        $pembelian->supplier_id = $id;
        $pembelian->tanggal_pembelian = Carbon::now()->toDateString();
        $pembelian->jenis_pembelian = 'cash';
        $pembelian->total_item = 0;
        $pembelian->total_harga = 0;
        $pembelian->diskon = 0;
        $pembelian->total_bayar = 0;
        $pembelian->status_pembayaran = 'L';
        $pembelian->catatan = '';
        $pembelian->save();

        request()->session()->put('pembelian_id', $pembelian->pembelian_id);
        request()->session()->put('supplier_id', $id);

        return redirect()->route('transactionPage.pembelian');
        
    }

    public function store(Request $request)
    {
        // return $request->all();
        $val = $request->validate([
            'pembelian_id'      => 'required',
            'total_harga'       => 'required',
            'total_item'        => 'required',
            'diskon'            => 'required',
            'total_bayar'       => 'required',
            'jenis_pembelian'   => 'required',
        ]);

       $pembelian_id = intval($val['pembelian_id']);
       $total_harga = intval($val['total_harga']);
       $total_item = intval($val['total_item']);
       $diskon = intval($val['diskon']);
       $total_bayar = intval($val['total_bayar']);

       $pembelian = PembelianModel::find($pembelian_id);

       if($request->jenis_pembelian == 'credit') {
            $request->validate([
                'uang_muka'             => 'required',
                'tanggal_jatuh_tempo'   => 'required',
            ]);
            $data = [
                'pembelian_id'  => $pembelian_id,
                'uang_muka'     => $request->uang_muka,
                'sisa_pembayaran'   => $total_bayar - $request->uang_muka,
                'tanggal_jatuh_tempo'   => $request->tanggal_jatuh_tempo,
                'status_pembayaran'     => 'U'
            ];
            UtangModel::create($data);
            $pembelian->status_pembayaran = 'U';
       } else {
            $pembelian->status_pembayaran = 'L';
       }
       
       $pembelian->jenis_pembelian = $request->jenis_pembelian;
       $pembelian->total_item = $total_item;
       $pembelian->total_harga = $total_harga;
       $pembelian->diskon = $diskon;
       $pembelian->total_bayar = $total_bayar;
       $pembelian->catatan = $request->catatan;
       $pembelian->update();

       $detail = DetailPembelianModel::where('pembelian_id', $pembelian_id)->get();
       foreach($detail as $item) {
            $produkStok = StokModel::where('product_id', $item->product_id)->first();
            $produkStok->total_stok += $item->jumlah;
            $produkStok->update_stok_date = Carbon::now()->toDateString();
            $produkStok->update();
       }

       return redirect()->route('index.pembelian')->with('toast_success', 'Transaksi Pembelian berhasil disimpan.');

    }

}
