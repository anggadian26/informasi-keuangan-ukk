<?php

namespace App\Http\Controllers;

use App\Exports\PembelianExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LaporanPembelianController extends Controller
{
    public function index() {
        return view('laporan.pembelian.index');
    }

    public function downloadLaporan(Request $request)
    {
        $action = $request->input('action');

        $request->validate(['select_filter' => 'required']);
        $filter = $request->select_filter;

        Carbon::setLocale('id');
        $parameter = '';
        
        $query = "
            SELECT A.*, B.name, C.supplier_name, C.supplier_company
            FROM pembelian A
            INNER JOIN users B ON A.record_id = B.id 
            INNER JOIN supplier C ON A.supplier_id = C.supplier_id
        ";

        if($filter == 'hari_ini') {
            $tanggal_hariIni = Carbon::now();   
            $query .= " WHERE A.tanggal_pembelian = '" . $tanggal_hariIni->toDateString() . "' ";
            $parameter = $tanggal_hariIni->translatedFormat('d F Y');
        } elseif($filter == 'kemarin') {
            $tanggal_Kemarin = Carbon::yesterday();
            $query .= " WHERE A.tanggal_pembelian = '" . $tanggal_Kemarin->toDateString() . "' ";
            $parameter = $tanggal_Kemarin->translatedFormat('d F Y');
        } elseif($filter == 'bulan_ini') {
            $bulan_ini = Carbon::now()->translatedFormat('F Y');
            $query .= " WHERE MONTH(A.tanggal_pembelian) = " . Carbon::now()->month . " AND YEAR(A.tanggal_pembelian) = " . Carbon::now()->year;
            $parameter = $bulan_ini;
        } elseif($filter == 'bulan_kemarin') {
            $bulan_kemarin = Carbon::now()->subMonth()->translatedFormat('F Y');
            $query .= " WHERE MONTH(A.tanggal_pembelian) = " . Carbon::now()->subMonth()->month . " AND YEAR(A.tanggal_pembelian) = " . Carbon::now()->subMonth()->year;
            $parameter = $bulan_kemarin;
        } elseif($filter == 'lainnya') {
            $request->validate([
                'date_from' => 'required|date',
                'date_to' => 'nullable|date|after_or_equal:date_from', 
            ]);
    
            $date_from = $request->date_from;
            $date_to = $request->date_to;
    
            if($date_from != null && $date_to != null) {
                $parameter = Carbon::parse($date_from)->translatedFormat('d F Y') . ' - ' . Carbon::parse($date_to)->translatedFormat('d F Y');
                $query .= " WHERE A.tanggal_pembelian BETWEEN '" . $date_from . "' AND '" . $date_to . "' ";
            } else {
                $parameter = Carbon::parse($date_from)->translatedFormat('d F Y');
                $query .= " WHERE A.tanggal_pembelian = '" . $date_from . "' ";
            }

        }
    
        $query .= " ORDER BY A.tanggal_pembelian ASC";
    
        $data = DB::select($query);

        if($action == 'pdf') {

            $pdf = Pdf::loadView("laporan.pembelian.pdf.viewDownload", compact('data', 'parameter'));
            $pdf->setPaper("a4", "landscape");
            
            return $pdf->download('laporan-pembelian-'. $filter . '.pdf');
        } elseif($action == 'excel') {
            return Excel::download(new PembelianExport("laporan.pembelian.excel.viewDownload", $data, $parameter), 'laporan-pembelian-'. $filter . '.xlsx');
        }
    }
}
