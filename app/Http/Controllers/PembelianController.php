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

}
