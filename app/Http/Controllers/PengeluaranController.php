<?php

namespace App\Http\Controllers;

use App\Models\PengeluaranModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengeluaranController extends Controller
{
    public function showData(Request $request) {
        $tanggal = $request->tanggal;

        $query = PengeluaranModel::query()
            ->select()
            ->from('pengeluaran')
            ->when($tanggal, function($query, $tanggal) {
                return $query->where('tanggal_pengeluaran', '=', $tanggal);
            })
            ->orderBy('tanggal_pengeluaran', 'desc');

        $data = $query->paginate(30);

        $queryCount = "
        SELECT COUNT(1) AS totalData
        FROM pengeluaran";

        $total = DB::select($queryCount);

        return view("pengeluaran.index", compact("data","total"));
    }
}
