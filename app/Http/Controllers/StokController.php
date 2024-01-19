<?php

namespace App\Http\Controllers;

use App\Models\StokModel;
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
}
