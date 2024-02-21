<?php

namespace App\Http\Controllers;

use App\Exports\PemasukkanExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LaporanPemasukkanController extends Controller
{
    public function index() {
        return view('laporan.pemasukkan.index');
    }

    public function downloadLaporan(Request $request)
    {
        $action = $request->input('action');

        $request->validate(['select_filter' => 'required']);
        $filter = $request->select_filter;

        Carbon::setLocale('id');
        $parameter = '';
        
        $query = "
            SELECT * 
            FROM pemasukkan 
        ";

        $queryCount = "SELECT ";

        if($filter == 'hari_ini') {
            $tanggal_hariIni = Carbon::now();   
            $query .= " WHERE tanggal_pemasukkan = '" . $tanggal_hariIni->toDateString() . "' ";
            $parameter = $tanggal_hariIni->translatedFormat('d F Y');

            $queryCount .= "SUM(total_nominal) AS total_nominal ";
            $queryCount .= "FROM pemasukkan WHERE tanggal_pemasukkan = '" . $tanggal_hariIni->toDateString() . "' ";
        } elseif($filter == 'kemarin') {
            $tanggal_Kemarin = Carbon::yesterday();
            $query .= " WHERE tanggal_pemasukkan = '" . $tanggal_Kemarin->toDateString() . "' ";
            $parameter = $tanggal_Kemarin->translatedFormat('d F Y');

            $queryCount .= "SUM(total_nominal) AS total_nominal ";
	        $queryCount .= "FROM pemasukkan WHERE tanggal_pemasukkan = '" . $tanggal_Kemarin->toDateString() . "' ";
        } elseif($filter == 'bulan_ini') {
            $bulan_ini = Carbon::now()->translatedFormat('F Y');
            $query .= " WHERE MONTH(tanggal_pemasukkan) = " . Carbon::now()->month . " AND YEAR(tanggal_pemasukkan) = " . Carbon::now()->year;
            $parameter = $bulan_ini;

            $queryCount .= "SUM(total_nominal) AS total_nominal ";
            $queryCount .= "FROM pemasukkan WHERE MONTH(tanggal_pemasukkan) = " . Carbon::now()->month . " AND YEAR(tanggal_pemasukkan) = " . Carbon::now()->year;
        } elseif($filter == 'bulan_kemarin') {
            $bulan_kemarin = Carbon::now()->subMonth()->translatedFormat('F Y');
            $query .= " WHERE MONTH(tanggal_pemasukkan) = " . Carbon::now()->subMonth()->month . " AND YEAR(tanggal_pemasukkan) = " . Carbon::now()->subMonth()->year;
            $parameter = $bulan_kemarin;

            $queryCount .= "SUM(total_nominal) AS total_nominal ";
            $queryCount .= "FROM pemasukkan WHERE MONTH(tanggal_pemasukkan) = " . Carbon::now()->subMonth()->month . " AND YEAR(tanggal_pemasukkan) = " . Carbon::now()->subMonth()->year;
        } elseif($filter == 'lainnya') {
            $request->validate([
                'date_from' => 'required|date',
                'date_to' => 'nullable|date|after_or_equal:date_from', 
            ]);
    
            $date_from = $request->date_from;
            $date_to = $request->date_to;
    
            if($date_from != null && $date_to != null) {
                $parameter = Carbon::parse($date_from)->translatedFormat('d F Y') . ' - ' . Carbon::parse($date_to)->translatedFormat('d F Y');
                $query .= " WHERE tanggal_pemasukkan BETWEEN '" . $date_from . "' AND '" . $date_to . "' ";

                $queryCount .= "SUM(total_nominal) AS total_nominal ";
                $queryCount .= "FROM pemasukkan WHERE tanggal_pemasukkan BETWEEN '" . $date_from . "' AND '" . $date_to . "' ";
            } else {
                $parameter = Carbon::parse($date_from)->translatedFormat('d F Y');
                $query .= " WHERE tanggal_pemasukkan = '" . $date_from . "' ";

                $queryCount .= "SUM(total_nominal) AS total_nominal ";
                $queryCount .= "FROM pemasukkan WHERE tanggal_pemasukkan = '" . $date_from . "' ";
            }

        }
    
        $query .= " ORDER BY tanggal_pemasukkan ASC";
    
        $data = DB::select($query);

        $count = DB::select($queryCount);



        if($action == 'pdf') {

            $pdf = Pdf::loadView("laporan.pemasukkan.pdf.viewDownload", compact('data', 'parameter', 'count'));
            $pdf->setPaper("a4", "potrait");
            
            return $pdf->download('laporan-pemasukkan-'. $filter . '.pdf');

        } elseif($action == 'excel') {
            return Excel::download(new PemasukkanExport("laporan.pemasukkan.excel.viewDownload", $data, $parameter, $count), 'laporan-pemasukkan-'. $filter . '.xlsx');
        }
    }
}
