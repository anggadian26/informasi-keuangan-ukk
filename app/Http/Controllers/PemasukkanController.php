<?php

namespace App\Http\Controllers;

use App\Models\PemasukkanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemasukkanController extends Controller
{
    public function showData(Request $request) {
        $tanggal = $request->tanggal;

        $query = PemasukkanModel::query()
            ->select('*')
            ->from('pemasukkan')
            ->when($tanggal, function($query, $tanggal) {
                return $query->where('tanggal_pemasukkan', '=', $tanggal);
            })
            ->orderBy('tanggal_pemasukkan', 'desc');

        $data = $query->paginate(30);

        $queryCount = "
            SELECT COUNT(1) AS totalData
            FROM pemasukkan";

        $total = DB::select($queryCount);
        
        return view("pemasukkan.index", compact("data", "total"));
    }
}
