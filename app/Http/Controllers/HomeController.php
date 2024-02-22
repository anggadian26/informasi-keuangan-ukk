<?php

namespace App\Http\Controllers;

use App\Models\PemasukkanModel;
use App\Models\PembelianModel;
use App\Models\PengeluaranModel;
use App\Models\PenjualanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function basePage() {
        $pendapatanQuery = "
            SELECT YEAR(tanggal_pemasukkan) as tahun, MONTH(tanggal_pemasukkan) as bulan, SUM(total_nominal) as pendapatan
            FROM pemasukkan
            GROUP BY YEAR(tanggal_pemasukkan), MONTH(tanggal_pemasukkan)
        ";
        $pendapatanData = DB::select($pendapatanQuery);

        $pengeluaranQuery = "
            SELECT YEAR(tanggal_pengeluaran) as tahun, MONTH(tanggal_pengeluaran) as bulan, SUM(total_nominal) as pengeluaran
            FROM pengeluaran
            GROUP BY YEAR(tanggal_pengeluaran), MONTH(tanggal_pengeluaran)
        ";
        $pengeluaranData = DB::select($pengeluaranQuery);

        $labarugi = [];
        foreach ($pendapatanData as $pendapatanItem) {
            $tahun = $pendapatanItem->tahun;
            $bulan = $pendapatanItem->bulan;
            $pendapatan = $pendapatanItem->pendapatan;

            $pengeluaran = 0;
            foreach ($pengeluaranData as $pengeluaranItem) {
                if ($pengeluaranItem->tahun == $tahun && $pengeluaranItem->bulan == $bulan) {
                    $pengeluaran = $pengeluaranItem->pengeluaran;
                    break;
                }
            }

            $namaBulan = date('F', mktime(0, 0, 0, $bulan, 1)); 
            $tahunBulan = $namaBulan . ' ' . $tahun;

            $labarugi[] = [
                'tahun_bulan' => $tahunBulan,
                'labarugi' => (int)$pendapatan - (int)$pengeluaran
            ];
        }

        usort($labarugi, function($a, $b) {
            $tahunA = substr($a['tahun_bulan'], strrpos($a['tahun_bulan'], ' ') + 1);
            $bulanA = array_search(substr($a['tahun_bulan'], 0, strrpos($a['tahun_bulan'], ' ')), array(
                'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
            ));

            $tahunB = substr($b['tahun_bulan'], strrpos($b['tahun_bulan'], ' ') + 1);
            $bulanB = array_search(substr($b['tahun_bulan'], 0, strrpos($b['tahun_bulan'], ' ')), array(
                'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
            ));

            if ($tahunA == $tahunB) {
                return $bulanA - $bulanB;
            }
            return $tahunA - $tahunB;
        });


        $pendapatanData = PemasukkanModel::select(DB::raw("SUM(total_nominal) as pendapatan"))
            ->groupBy(DB::raw("YEAR(tanggal_pemasukkan)"), DB::raw('MONTH(tanggal_pemasukkan)'))
            ->pluck('pendapatan');

        $pendapatanCollection = collect($pendapatanData);

        $pendapatan = $pendapatanCollection->map(function ($item) {
                return (int) $item;
        });
            

        $bulan_pendapatan = PemasukkanModel::select(
            DB::raw("GROUP_CONCAT(DISTINCT DATE_FORMAT(tanggal_pemasukkan, '%M %Y')) as bulan_pendapatan")
          )
            ->groupBy(DB::raw('YEAR(tanggal_pemasukkan)'), DB::raw('MONTH(tanggal_pemasukkan)'))
            ->pluck('bulan_pendapatan');

        

        // Pengeluaran
        $pengeluaranData = PengeluaranModel::select(DB::raw("SUM(total_nominal) as pengeluaran"))
            ->groupBy(DB::raw("YEAR(tanggal_pengeluaran)"), DB::raw('MONTH(tanggal_pengeluaran)'))
            ->pluck('pengeluaran');

        $pengeluaranCollection = collect($pengeluaranData);

        $pengeluaran = $pengeluaranCollection->map(function ($item) {
                return (int) $item;
        });
            

        $bulan_pengeluaran = PengeluaranModel::select(
            DB::raw("GROUP_CONCAT(DISTINCT DATE_FORMAT(tanggal_pengeluaran, '%M %Y')) as bulan_pengeluaran")
          )
            ->groupBy(DB::raw('YEAR(tanggal_pengeluaran)'), DB::raw('MONTH(tanggal_pengeluaran)'))
            ->pluck('bulan_pengeluaran');

        
        $currentYear = date('Y');

        $nominal_pemasukkanData = PemasukkanModel::select(DB::raw("SUM(total_nominal) as nominal_pemasukkan"))
            ->whereYear('tanggal_pemasukkan', $currentYear)
            ->pluck('nominal_pemasukkan');

        $nominalPemasukkanColl = collect($nominal_pemasukkanData);

        $nominal_pemasukkan = $nominalPemasukkanColl->map(function ($item) {
                return (int) $item;
        });

        // pengeluaran
        $nominal_pengeluaranData = PengeluaranModel::select(DB::raw("SUM(total_nominal) as nominal_pengeluaran"))
            ->whereYear('tanggal_pengeluaran', $currentYear)
            ->pluck('nominal_pengeluaran');

        $nominalPengeluaranColl = collect($nominal_pengeluaranData);

        $nominal_pengeluaran = $nominalPengeluaranColl->map(function ($item) {
                return (int) $item;
        });

        $total_penjualan = PenjualanModel::where('record_id', auth()->id())->count();
        $total_pembelian = PembelianModel::where('record_id', auth()->id())->count();

        return view('home.index', compact('labarugi', 'pendapatan', 'bulan_pendapatan', 'pengeluaran', 'bulan_pengeluaran', 
            'nominal_pemasukkan', 'nominal_pengeluaran', 'total_penjualan', 'total_pembelian'));
    }
}