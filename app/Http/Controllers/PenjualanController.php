<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualanModel;
use App\Models\DetailPiutangModel;
use App\Models\PemasukkanModel;
use App\Models\PenjualanModel;
use App\Models\PiutangModel;
use App\Models\StokModel;
use App\Models\SupplierModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function showData(Request $request)
    {
        $tanggal_penjualan = $request->tanggal_penjualan;
        $status_pembayaran = $request->status_pembayaran;
        $jenis_transaksi = $request->jenis_transaksi;

        $query = PenjualanModel::query()
            ->select('A.*', 'B.name')
            ->from('penjualan AS A')
            ->join('users AS B', 'A.record_id', '=', 'B.id')
            ->when($tanggal_penjualan, function($query, $tanggal_penjualan) {
                return $query->where('A.tanggal_penjualan', '=', $tanggal_penjualan);
            }) 
            ->when($jenis_transaksi, function($query, $jenis_transaksi) {
                return $query->where('A.jenis_transaksi', '=', $jenis_transaksi);
            }) 
            ->when($status_pembayaran, function($query, $status_pembayaran) {
                return $query->where('A.status_pembayaran', '=', $status_pembayaran);
            }) 
            ->orderBy('A.tanggal_penjualan', 'DESC')
            ;
        
        $penjualan = $query->paginate(30);

        $queryCount = "
            SELECT COUNT(1) AS totalData
            FROM penjualan";

        $total = DB::select($queryCount);

        return view('penjualan.index', compact('penjualan', 'total'));
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
        $penjualan->flg_member = 'N';
        $penjualan->member_id = null;
        $penjualan->total_item = 0;
        $penjualan->total_harga = 0;
        $penjualan->diskon = 0;
        $penjualan->harga_akhir = 0;
        $penjualan->bayar = 0;
        $penjualan->kembalian = 0;
        $penjualan->status_pembayaran = 'L';
        $penjualan->catatan = null;
        $penjualan->record_id = Auth::id();
        $penjualan->save();

        session(['penjualan_id' => $penjualan->penjualan_id]);
        return redirect()->route('transactionPage.penjualan');
    }

    public function store(Request $request)
    {
        // return $request->all();
        $val = $request->validate([
            'total_harga'       => 'required',
            'total_item'        => 'required',
            'penjualan_id'      => 'required',
        ]);

        $penjualan_id = intval($val['penjualan_id']);
        $total_item = intval($val['total_item']);
        $total_harga = intval($val['total_harga']);
        $bayar = intval($request->bayar);
        $kembalian =  intval($request->kembalian);
        
        $uang_muka = intval($request->uang_muka);

        $penjualan = PenjualanModel::find($penjualan_id);

        if($request->jenis_transaksi == 'credit') {
            $request->validate([
                'nama_customer'     => 'required',
                'alamat_customer'   => 'required',
                'dp_zero'           => 'required',
                'tanggal_jatuh_tempo'   => 'required',
                'diterima'      => 'nullable',
                'bayar' => 'nullable',

            ]);

            if($request->dp_zero == 'Y') {
                $request->validate([
                    'uang_muka'     => 'nullable',
                ]);
                $uang_muka_result = 0;
            } else {
                $request->validate([
                    'uang_muka'     => 'required',
                ]);
                $uang_muka_result = $uang_muka;
            }

            $piutangData = [
                'penjualan_id'          => $penjualan_id,
                'dp_zero'               => $request->dp_zero,
                'nama_customer'         => $request->nama_customer,
                'alamat_customer'       => $request->alamat_customer,
                'jumlah_piutang'        => $total_harga,
                'uang_muka'             => $uang_muka_result,
                'sisa_piutang'          => $total_harga - $uang_muka_result,
                'tanggal_jatuh_tempo'   => $request->tanggal_jatuh_tempo,
                'status_pembayaran'     => 'U',
            ];
            
            $piutang = PiutangModel::create($piutangData);
            
            $detailPiutangData = [
                'piutang_id'    => $piutang->piutang_id,
                'detail_tanggal'    => Carbon::now()->toDateString(),
                'bayar'             => $uang_muka_result,
                'sisa'              => $piutang->sisa_piutang,
                'record_id'         => Auth::user()->id,
            ];
            
            $detailPiutang = DetailPiutangModel::create($detailPiutangData);

            $pemasukkanData = [
                'jenis_pemasukkan'  => 'P',
                'tanggal_pemasukkan'    => Carbon::now()->toDateString(),
                'total_nominal'     => $uang_muka_result,
                'keterangan'        => 'Pemasukan Penjualan [Credit]'
            ];

            PemasukkanModel::create($pemasukkanData);
            
            $penjualan->jenis_transaksi = 'credit';
            $penjualan->bayar = 0;
            $penjualan->kembalian = 0;
            $penjualan->status_pembayaran = 'U';
        } else {
            $request->validate([
                'bayar'             => 'required',
                'kembalian'         => 'required',
                'jenis_transaksi'   => 'required',
                'diterima'          => 'required',
            ]);
            $penjualan->jenis_transaksi = 'cash';
            $penjualan->status_pembayaran = 'L';
            $penjualan->bayar = $bayar;
            $penjualan->kembalian = $kembalian;
            
            $pemasukkanData = [
                'jenis_pemasukkan'  => 'P',
                'tanggal_pemasukkan'    => Carbon::now()->toDateString(),
                'total_nominal'     => $total_harga,
                'keterangan'        => 'Pemasukan Penjualan [Cash]'
            ];
            
            PemasukkanModel::create($pemasukkanData);
        }
        
        $penjualan->total_item = $total_item;
        $penjualan->total_harga = $total_harga;
        $penjualan->harga_akhir = $total_harga;
        $penjualan->catatan = $request->catatan;
        $penjualan->update();

        $detail = DetailPenjualanModel::where('penjualan_id', $penjualan_id)->get();
        foreach($detail as $item) {
             $produkStok = StokModel::where('product_id', $item->product_id)->first();
             $produkStok->total_stok -= $item->jumlah;
             $produkStok->update_stok_date = Carbon::now()->toDateString();
             $produkStok->update();
        }

        return redirect()->route('index.penjualan')->with('toast_success', 'Transaksi Penjualan berhasil disimpan.');
    }

    public function detailData($id){

        $query = "
            SELECT A.*, B.product_name, B.product_code, B.product_purcase
            FROM detail_penjualan A
            INNER JOIN product B ON A.product_id = B.product_id
            WHERE A.penjualan_id = ?
        ";

        $detail = DB::select($query, [$id]);
        // $pembelian = PembelianModel::find($id);
        $queryPenjualan = "
            SELECT A.*, B.name
            FROM penjualan A
            INNER JOIN users B ON A.record_id = B.id
            WHERE A.penjualan_id = ?
        ";

        $penjualan = DB::select($queryPenjualan, [$id]);

        return response()->json(['detail' => $detail, 'penjualan' => $penjualan]);
    }
}
