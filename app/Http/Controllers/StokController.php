<?php

namespace App\Http\Controllers;

use App\Models\StokModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
    public function showData(Request $request) {
        $product_code = $request->product_code;
        $product_name = $request->product_name;

        $query = StokModel::query()
            ->select('A.*', 'B.product_code', 'B.product_name')
            ->from('stok AS A')
            ->join('product AS B', 'A.product_id', '=', 'B.product_id')
            ->when($product_code, function($query, $product_code) {
                return $query->where('B.product_code', 'like', '%' .$product_code. '%');
            })
            ->when($product_name, function($query, $product_name) {
                return $query->where('B.product_name', 'like', '%' .$product_name. '%');
            })
            ->orderBy('B.product_code')
            ->orderBy('B.product_name')
        ;

        $stok = $query->paginate(50);

        $queryCount = "
            SELECT COUNT(1) AS totalData
            FROM stok";

        $total = DB::select($queryCount);

        return view('stok.index', compact(['stok', 'total']));
    }

    public function downloadLaporan() {
        Carbon::setLocale('id');
        $tanggal_hariIni = Carbon::now();
        $parameter = $tanggal_hariIni->translatedFormat('d F Y');

        $query = "
            SELECT A.*, B.product_code, B.product_name
            FROM stok A
            INNER JOIN product B ON A.product_id = B.product_id
            ORDER BY B.product_code, B.product_name
        ";

        $data = DB::select($query);
        $pdf = Pdf::loadView("stok.viewDownload", compact('data', 'parameter'));
        $pdf->setPaper("a4", "potrait");
            
        return $pdf->download('laporan-stok-'. $tanggal_hariIni . '.pdf');
    }
}
