<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel;
use App\Models\SupplierModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    public function showData(Request $request)
    {
        $supplier = SupplierModel::all();

        return view('penjualan.index', compact(['supplier']));
    }

    public function create() {
        $today = date("Ymd"); 
        $random = mt_rand(1000, 9999); 

        $number = $today . $random; 

        if(PenjualanModel::where('nota', $number)->exists()) {
            $random = mt_rand(1000, 9999); 
            $number = $today . $random;
        }
        $penjualan = new PenjualanModel();
        $penjualan->nota = $number;
        $penjualan->tanggal_penjualan = Carbon::now()->toDateString();
        $penjualan->jenis_transaksi = 'cash';
        $penjualan->flg_member = 'Y';
        $penjualan->member_id = null;
        $penjualan->total_item = 0;
        $penjualan->total_harga = 0;
        $penjualan->diskon = 0;
        $penjualan->result_harga = 0;
        $penjualan->bayar = 0;
        $penjualan->kembalian = 0;
        $penjualan->status_pembayaran = 'L';
        $penjualan->catatan = null;
        $penjualan->record_id = Auth::id();
        $penjualan->save();

        session(['penjualan_id' => $penjualan->penjualan_id]);
        return redirect();
    }
}
