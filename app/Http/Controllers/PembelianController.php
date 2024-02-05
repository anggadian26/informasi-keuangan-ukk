<?php

namespace App\Http\Controllers;

use App\Models\DetailPembelianModel;
use App\Models\DetailUtangModel;
use App\Models\PembelianModel;
use App\Models\PengeluaranModel;
use App\Models\ProductModel;
use App\Models\StokModel;
use App\Models\SupplierModel;
use App\Models\UtangModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function showData(Request $request)
    {
        $supplier = SupplierModel::all();

        $tanggal_pembelian = $request->tanggal_pembelian;
        $supplier_id = $request->supplier_id;
        $jenis_pembelian = $request->jenis_pembelian;

        $query = PembelianModel::query()
            ->select('A.*', 'B.supplier_name')
            ->from('pembelian AS A')
            ->join('supplier AS B', 'A.supplier_id', '=', 'B.supplier_id')
            ->when($tanggal_pembelian, function($query, $tanggal_pembelian) {
                return $query->where('A.tanggal_pembelian', '=', $tanggal_pembelian);
            })
            ->when($supplier_id, function($query, $supplier_id) {
                return $query->where('A.supplier_id', '=', $supplier_id);
            })
            ->when($jenis_pembelian, function($query, $jenis_pembelian) {
                return $query->where('A.jenis_pembelian', '=', $jenis_pembelian);
            })
            ->orderBy('A.tanggal_pembelian', 'DESC')
        ;

        // $pembelians = PembelianModel::with('supplier', 'details.product');

        $pembelian = $query->paginate(30);

        $queryCount = "
            SELECT COUNT(1) AS totalData
            FROM pembelian";

        $total = DB::select($queryCount);
        
        // return response()->json($data);
        return view('pembelian.index', compact('supplier', 'pembelian', 'total'));
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
        $today = date("Ymd"); 
        $random = mt_rand(1000, 9999); 

        $number = $today . $random; 

        if(PembelianModel::where('nota', $number)->exists()) {
            $random = mt_rand(1000, 9999); 
            $number = $today . $random;
        }

        $pembelian = new PembelianModel();
        $pembelian->supplier_id = $id;
        $pembelian->nota = $number;
        $pembelian->tanggal_pembelian = Carbon::now()->toDateString();
        $pembelian->jenis_pembelian = 'cash';
        $pembelian->total_item = 0;
        $pembelian->total_harga = 0;
        $pembelian->diskon = 0;
        $pembelian->total_bayar = 0;
        $pembelian->status_pembayaran = 'L';
        $pembelian->catatan = '';
        $pembelian->record_id = Auth::id();
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
                'tanggal'       => Carbon::now()->toDateString(),
                'uang_muka'     => $request->uang_muka,
                'sisa_pembayaran'   => $total_bayar - $request->uang_muka,
                'tanggal_jatuh_tempo'   => $request->tanggal_jatuh_tempo,
                'status_pembayaran'     => 'U'
            ];
            $utang = UtangModel::create($data);

            $dataDetail = [
                'utang_id'          => $utang->utang_id,
                'detail_tanggal'    => Carbon::now()->toDateString(),
                'bayar'             => $utang->uang_muka,
                'sisa'              => $utang->sisa_pembayaran,
                'record_id'         => Auth::user()->id,
            ];

            DetailUtangModel::create($dataDetail);

            $pengeluaranData = [
                'jenis_pengeluaran'     => 'P',
                'tanggal_pengeluaran'   => Carbon::now()->toDateString(),
                'total_nominal'         => $request->uang_muka,
                'keterangan'            => 'Pembelian Credit'
            ];
            PengeluaranModel::create($pengeluaranData);

            $pembelian->status_pembayaran = 'U';

       } else {
            $pembelian->status_pembayaran = 'L';

            $pengeluaranData = [
                'jenis_pengeluaran'     => 'P',
                'tanggal_pengeluaran'   => Carbon::now()->toDateString(),
                'total_nominal'         => $total_bayar,
                'keterangan'            => 'Pembelian Cash'
            ];
            PengeluaranModel::create($pengeluaranData);
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

    public function detailData($id) {

        // $detail = DetailPembelianModel::where('pembelian_id', $id)->get();
        $query = "
            SELECT A.*, B.product_name, B.product_code, B.product_purcase
            FROM detail_pembelian A
            INNER JOIN product B ON A.product_id = B.product_id
            WHERE A.pembelian_id = ?
        ";

        $detail = DB::select($query, [$id]);
        // $pembelian = PembelianModel::find($id);
        $queryPembelian = "
            SELECT A.*, B.name
            FROM pembelian A
            INNER JOIN users B ON A.record_id = B.id
            WHERE A.pembelian_id = ?
        ";

        $pembelian = DB::select($queryPembelian, [$id]);

        return response()->json(['detail' => $detail, 'pembelian' => $pembelian]);
    }

}
