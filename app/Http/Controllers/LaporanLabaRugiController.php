<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanLabaRugiController extends Controller
{
    public function index() {
        return view('laporan.laba-rugi.index');
    }

    public function downloadLaporan(Request $request)
    {
        $request->validate(['select_filter' => 'required']);
        $filter = $request->select_filter;

        Carbon::setLocale('id');
        $parameter = '';
        
        $queryPendapatan = "
            SELECT SUM(total_nominal) AS pendapatan
            FROM pemasukkan 
        ";

        $queryPengeluaran = "
            SELECT SUM(total_nominal) AS pengeluaran
            FROM pengeluaran
        ";


        if($filter == 'hari_ini') {
            $tanggal_hariIni = Carbon::now();   
            $queryPendapatan .= " WHERE tanggal_pemasukkan = '" . $tanggal_hariIni->toDateString() . "' ";
            $queryPengeluaran .= " WHERE tanggal_pengeluaran = '" . $tanggal_hariIni->toDateString() . "' ";
            $parameter = $tanggal_hariIni->translatedFormat('d F Y');
        } elseif($filter == 'kemarin') {
            $tanggal_Kemarin = Carbon::yesterday();
            $queryPendapatan .= " WHERE tanggal_pemasukkan = '" . $tanggal_Kemarin->toDateString() . "' ";
            $queryPengeluaran .= " WHERE tanggal_pengeluaran = '" . $tanggal_Kemarin->toDateString() . "' ";
            $parameter = $tanggal_Kemarin->translatedFormat('d F Y');
        } elseif($filter == 'bulan_ini') {
            $bulan_ini = Carbon::now()->translatedFormat('F Y');
            $queryPendapatan .= " WHERE MONTH(tanggal_pemasukkan) = " . Carbon::now()->month . " AND YEAR(tanggal_pemasukkan) = " . Carbon::now()->year;
            $queryPengeluaran .= " WHERE MONTH(tanggal_pengeluaran) = " . Carbon::now()->month . " AND YEAR(tanggal_pengeluaran) = " . Carbon::now()->year;
            $parameter = $bulan_ini;
        } elseif($filter == 'bulan_kemarin') {
            $bulan_kemarin = Carbon::now()->subMonth()->translatedFormat('F Y');
            $queryPendapatan .= " WHERE MONTH(tanggal_pemasukkan) = " . Carbon::now()->subMonth()->month . " AND YEAR(tanggal_pemasukkan) = " . Carbon::now()->subMonth()->year;
            $queryPengeluaran .= " WHERE MONTH(tanggal_pengeluaran) = " . Carbon::now()->subMonth()->month . " AND YEAR(tanggal_pengeluaran) = " . Carbon::now()->subMonth()->year;
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
                $queryPendapatan .= " WHERE tanggal_pemasukkan BETWEEN '" . $date_from . "' AND '" . $date_to . "' ";
                $queryPengeluaran .= " WHERE tanggal_pengeluaran BETWEEN '" . $date_from . "' AND '" . $date_to . "' ";
            } else {
                $parameter = Carbon::parse($date_from)->translatedFormat('d F Y');
                $queryPendapatan .= " WHERE tanggal_pemasukkan = '" . $date_from . "' ";
                $queryPengeluaran .= " WHERE tanggal_pengeluaran = '" . $date_from . "' ";
            }

        }
    
        $pendapatan = DB::select($queryPendapatan);

        $pengeluaran = DB::select($queryPengeluaran);

        $labaRugi = $pendapatan[0]->pendapatan - $pengeluaran[0]->pengeluaran;

        $pdf = Pdf::loadView("laporan.laba-rugi.pdf.viewDownload", compact('pendapatan', 'pengeluaran', 'labaRugi', 'parameter'));
        $pdf->setPaper("a4", "potrait");
            
        return $pdf->download('laporan-labarugi-'. $filter . '.pdf');
    }
}
