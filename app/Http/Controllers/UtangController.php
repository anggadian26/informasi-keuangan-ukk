<?php

namespace App\Http\Controllers;

use App\Models\DetailUtangModel;
use App\Models\PembelianModel;
use App\Models\PengeluaranModel;
use App\Models\UtangModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UtangController extends Controller
{
    public function showData(Request $request)
    {
        $tanggal = $request->tanggal;
        $tanggal_jatuh_tempo = $request->tanggal_jatuh_tempo;
        $status_pembayaran = $request->status_pembayaran;

        $query = UtangModel::query()
            ->select('A.*', 'B.nota', 'B.total_bayar')
            ->from('utang AS A')
            ->join('pembelian AS B', 'A.pembelian_id', '=', 'B.pembelian_id')
            ->when($tanggal, function($query, $tanggal) {
                return $query->where('A.tanggal', $tanggal);
            })
            ->when($tanggal_jatuh_tempo, function($query, $tanggal_jatuh_tempo) {
                return $query->where('A.tanggal_jatuh_tempo', $tanggal_jatuh_tempo);
            })
            ->when($status_pembayaran, function($query, $status_pembayaran) {
                return $query->where('A.status_pembayaran', $status_pembayaran);
            })
            ->orderBy('A.status_pembayaran', 'desc')
            ->orderBy('A.tanggal_jatuh_tempo', 'asc')
        ;

        $utang = $query->paginate(20);

        $queryCount = "
            SELECT COUNT(1) AS totalData
            FROM utang    
        ";

        $total = DB::select($queryCount);
        // return $utang;
        return view("utang.index", compact(['utang', 'total']));
    }

    public function detailUtang($id) 
    {
        
        $query = "
            SELECT A.*, B.name
            FROM detail_utang A
            INNER JOIN users B ON A.record_id = B.id
            WHERE utang_id = ?
            ORDER BY detail_tanggal ASC
        ";

        $utang = DB::select($query, [$id]);

        return response()->json(["utang" => $utang]);
    }

    public function bayarUtang(Request $request)
    {
        // dd($request->all());
        $val = $request->validate([
            'bayar' => 'required',
            'utang_id'  => 'required',
        ]);

        $utang = UtangModel::find($val['utang_id']);

        $request->validate([
            'bayar' => 'required|numeric|min:0.01|max:' . $utang->sisa_pembayaran,
            'utang_id' => 'required',
        ], [
            'bayar.max' => 'Nilai pembayaran tidak boleh lebih besar dari sisa pembayaran utang.',
        ]);

        $utang_sisa = $utang->sisa_pembayaran - $val['bayar'];

        $data = [
            'utang_id'  => $val['utang_id'],
            'detail_tanggal'    => Carbon::now()->toDateString(),
            'bayar' => $val['bayar'],
            'sisa'  => $utang_sisa,
            'record_id' => Auth::user()->id,
        ];

        $detail_utang = DetailUtangModel::create($data);

        $utang->update([
            'sisa_pembayaran' => $utang_sisa
        ]);

        if ($utang_sisa == 0) {
            $utang->update([
                'status_pembayaran' => 'L'
            ]);

            $pembelian = PembelianModel::find($utang->pembelian_id);
            $pembelian->update([
                'status_pembayaran' => 'L'
            ]);
        }

        $dataPengeluaran = [
            'jenis_pengeluaran'     => 'P',
            'tanggal_pengeluaran'   => Carbon::now()->toDateString(),
            'total_nominal'         => $val['bayar'],
            'keterangan'            => 'Pembayaran Credit'
        ]; 

        PengeluaranModel::create($dataPengeluaran);


        return redirect()->route('index.utang')->with('toast_success', 'Pembayaran utang telah sukses!');
    }


}
