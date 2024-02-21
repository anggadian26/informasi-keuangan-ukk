<?php

namespace App\Http\Controllers;

use App\Exports\PengeluaranExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LaporanPengeluaranController extends Controller
{
    public function index() {
        return view('laporan.pengeluaran.index');
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
            FROM pengeluaran 
        ";

        $queryCount = "SELECT ";

        if($filter == 'hari_ini') {
            $tanggal_hariIni = Carbon::now();   
            $query .= " WHERE tanggal_pengeluaran = '" . $tanggal_hariIni->toDateString() . "' ";
            $parameter = $tanggal_hariIni->translatedFormat('d F Y');

            $queryCount .= "SUM(total_nominal) AS total_nominal ";
            $queryCount .= "FROM pengeluaran WHERE tanggal_pengeluaran = '" . $tanggal_hariIni->toDateString() . "' ";
        } elseif($filter == 'kemarin') {
            $tanggal_Kemarin = Carbon::yesterday();
            $query .= " WHERE tanggal_pengeluaran = '" . $tanggal_Kemarin->toDateString() . "' ";
            $parameter = $tanggal_Kemarin->translatedFormat('d F Y');

            $queryCount .= "SUM(total_nominal) AS total_nominal ";
	        $queryCount .= "FROM pengeluaran WHERE tanggal_pengeluaran = '" . $tanggal_Kemarin->toDateString() . "' ";
        } elseif($filter == 'bulan_ini') {
            $bulan_ini = Carbon::now()->translatedFormat('F Y');
            $query .= " WHERE MONTH(tanggal_pengeluaran) = " . Carbon::now()->month . " AND YEAR(tanggal_pengeluaran) = " . Carbon::now()->year;
            $parameter = $bulan_ini;

            $queryCount .= "SUM(total_nominal) AS total_nominal ";
            $queryCount .= "FROM pengeluaran WHERE MONTH(tanggal_pengeluaran) = " . Carbon::now()->month . " AND YEAR(tanggal_pengeluaran) = " . Carbon::now()->year;
        } elseif($filter == 'bulan_kemarin') {
            $bulan_kemarin = Carbon::now()->subMonth()->translatedFormat('F Y');
            $query .= " WHERE MONTH(tanggal_pengeluaran) = " . Carbon::now()->subMonth()->month . " AND YEAR(tanggal_pengeluaran) = " . Carbon::now()->subMonth()->year;
            $parameter = $bulan_kemarin;

            $queryCount .= "SUM(total_nominal) AS total_nominal ";
            $queryCount .= "FROM pengeluaran WHERE MONTH(tanggal_pengeluaran) = " . Carbon::now()->subMonth()->month . " AND YEAR(tanggal_pengeluaran) = " . Carbon::now()->subMonth()->year;
        } elseif($filter == 'lainnya') {
            $request->validate([
                'date_from' => 'required|date',
                'date_to' => 'nullable|date|after_or_equal:date_from', 
            ]);
    
            $date_from = $request->date_from;
            $date_to = $request->date_to;
    
            if($date_from != null && $date_to != null) {
                $parameter = Carbon::parse($date_from)->translatedFormat('d F Y') . ' - ' . Carbon::parse($date_to)->translatedFormat('d F Y');
                $query .= " WHERE tanggal_pengeluaran BETWEEN '" . $date_from . "' AND '" . $date_to . "' ";

                $queryCount .= "SUM(total_nominal) AS total_nominal ";
                $queryCount .= "FROM pengeluaran WHERE tanggal_pengeluaran BETWEEN '" . $date_from . "' AND '" . $date_to . "' ";
            } else {
                $parameter = Carbon::parse($date_from)->translatedFormat('d F Y');
                $query .= " WHERE tanggal_pengeluaran = '" . $date_from . "' ";

                $queryCount .= "SUM(total_nominal) AS total_nominal ";
                $queryCount .= "FROM pengeluaran WHERE tanggal_pengeluaran = '" . $date_from . "' ";
            }

        }
    
        $query .= " ORDER BY tanggal_pengeluaran ASC";
    
        $data = DB::select($query);

        $count = DB::select($queryCount);



        if($action == 'pdf') {

            $pdf = Pdf::loadView("laporan.pengeluaran.pdf.viewDownload", compact('data', 'parameter', 'count'));
            $pdf->setPaper("a4", "potrait");
            
            return $pdf->download('laporan-pengeluaran-'. $filter . '.pdf');

        } elseif($action == 'excel') {
            return Excel::download(new PengeluaranExport("laporan.pengeluaran.excel.viewDownload", $data, $parameter, $count), 'laporan-pengeluaran-'. $filter . '.xlsx');
        }
    }
}
