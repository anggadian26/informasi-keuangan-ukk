<?php

namespace App\Http\Controllers;

use App\Models\PembelianModel;
use App\Models\PenjualanModel;
use App\Models\ReturnBarangModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

date_default_timezone_set("Asia/Jakarta");

class InfoStokController extends Controller
{
    public function showData(Request $request) 
    {
        $tanggal = $request->tanggal;
        
        if($tanggal != null) {
            $penjualan = PenjualanModel::where('tanggal_penjualan', $tanggal)->get();
            $pembelian = PembelianModel::where('tanggal_pembelian', $tanggal)->get();
            $returns = ReturnBarangModel::where('tanggal', $tanggal)->get();
        } else {
            $penjualan = PenjualanModel::all();
            $pembelian = PembelianModel::all();
            $returns = ReturnBarangModel::all();
        }

        // Mengumpulkan semua tanggal yang muncul di tiga tabel
        $mergeData = [];
        foreach ($penjualan as $data) {
            $mergeData[$data->tanggal_penjualan]['tanggal'] = Carbon::parse($data->tanggal_penjualan)->translatedFormat('l, d F Y');
        }
        foreach ($pembelian as $data) {
            $mergeData[$data->tanggal_pembelian]['tanggal'] = Carbon::parse($data->tanggal_pembelian)->translatedFormat('l, d F Y');
        }
        foreach ($returns as $data) {
            $mergeData[$data->tanggal]['tanggal'] = Carbon::parse($data->tanggal)->translatedFormat('l, d F Y');
        }

        // Mengumpulkan data untuk setiap tanggal
        foreach ($mergeData as $tanggal => $value) {
            $details = [];

            foreach ($penjualan as $data) {
                if ($data->tanggal_penjualan == $tanggal) {
                    $details[] = [
                        'id'            => $data->penjualan_id,
                        'flg'           => 'J',        
                        'tanggal'       => $data->tanggal_penjualan,
                        'masuk'         => null,
                        'keluar'        => $data->total_item,
                        'keterangan'    => 'Penjualan'
                    ];
                }
            }

            foreach ($pembelian as $data) {
                if ($data->tanggal_pembelian == $tanggal) {
                    $details[] = [
                        'id'            => $data->pembelian_id,
                        'flg'           => 'B',
                        'tanggal'       => $data->tanggal_pembelian ,
                        'masuk'         => $data->total_item,
                        'keluar'        => null,
                        'keterangan'    => 'Pembelian'
                    ];
                }
            }

            foreach ($returns as $data) {
                if ($data->tanggal == $tanggal) {
                    $details[] = [
                        'id'            => $data->return_barang_id,
                        'flg'           => 'R',
                        'tanggal'       => $data->tanggal,
                        'masuk'         => $data->jumlah_return,
                        'keluar'        => null,
                        'keterangan'    => 'Return Barang'
                    ];
                }
            }

            $mergeData[$tanggal]['detail'] = $details;
        }

        // return $mergeData;
        return view('info-stok.index', compact('mergeData'));
    }

    public function detailDataStok($id, $flg) {
        if($flg == 'B') {
            $query = "
                SELECT A.*, B.product_name, B.product_code, B.product_purcase
                FROM detail_pembelian A
                INNER JOIN product B ON A.product_id = B.product_id
                WHERE A.pembelian_id = ? 
            ";

            $detail = DB::select($query, [$id]);
        }elseif($flg == 'J') {
            $query = "
                SELECT A.*, B.product_name, B.product_code, B.product_purcase
                FROM detail_penjualan A
                INNER JOIN product B ON A.product_id = B.product_id
                WHERE A.penjualan_id = ? 
            ";

            $detail = DB::select($query, [$id]);
        }elseif($flg == 'R') {
            $query = "
                SELECT A.*, B.product_name, B.product_code, B.product_purcase
                FROM return_barang A
                INNER JOIN product B ON A.product_id = B.product_id
                WHERE A.return_barang_id = ? 
            ";

            $detail = DB::select($query, [$id]);
        }

        return response()->json(['detail' => $detail]);
    }
}
