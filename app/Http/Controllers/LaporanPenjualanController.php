<?php

namespace App\Http\Controllers;

use App\Exports\PenjualanExport;
use App\Models\PenjualanModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class LaporanPenjualanController extends Controller
{
    public function index() {
        return view('laporan.penjualan.index');
    }

    public function filterPdf(Request $request) {
        $action = $request->input('action');

        $request->validate(['select_filter' => 'required']);
        $filter = $request->select_filter;

        Carbon::setLocale('id');
        $parameter = '';
        
        $query = "
            SELECT A.*, B.name
            FROM penjualan A
            INNER JOIN users B ON A.record_id = B.id 
        ";

        if($filter == 'hari_ini') {
            $tanggal_hariIni = Carbon::now();   
            $query .= " WHERE A.tanggal_penjualan = '" . $tanggal_hariIni->toDateString() . "' ";
            $parameter = $tanggal_hariIni->translatedFormat('d F Y');
        } elseif($filter == 'kemarin') {
            $tanggal_Kemarin = Carbon::yesterday();
            $query .= " WHERE A.tanggal_penjualan = '" . $tanggal_Kemarin->toDateString() . "' ";
            $parameter = $tanggal_Kemarin->translatedFormat('d F Y');
        } elseif($filter == 'bulan_ini') {
            $bulan_ini = Carbon::now()->translatedFormat('F Y');
            $query .= " WHERE MONTH(A.tanggal_penjualan) = " . Carbon::now()->month . " AND YEAR(A.tanggal_penjualan) = " . Carbon::now()->year;
            $parameter = $bulan_ini;
        } elseif($filter == 'bulan_kemarin') {
            $bulan_kemarin = Carbon::now()->subMonth()->translatedFormat('F Y');
            $query .= " WHERE MONTH(A.tanggal_penjualan) = " . Carbon::now()->subMonth()->month . " AND YEAR(A.tanggal_penjualan) = " . Carbon::now()->subMonth()->year;
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
                $query .= " WHERE A.tanggal_penjualan BETWEEN '" . $date_from . "' AND '" . $date_to . "' ";
            } else {
                $parameter = Carbon::parse($date_from)->translatedFormat('d F Y');
                $query .= " WHERE A.tanggal_penjualan = '" . $date_from . "' ";
            }

        }
    
        $query .= " ORDER BY A.tanggal_penjualan ASC";
    
        $data = DB::select($query);

        if($action == 'pdf') {

            $pdf = Pdf::loadView("laporan.penjualan.pdf.viewDownload", compact('data', 'parameter'));
            $pdf->setPaper("a4", "potrait");
            
            return $pdf->download('laporan-penjualan-'. $filter . '.pdf');
        } elseif($action == 'excel') {
            return Excel::download(new PenjualanExport("laporan.penjualan.excel.viewDownload", $data, $parameter), 'laporan-penjualan-'. $filter . '.xlsx');
        }
    }

}
