<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiskonController extends Controller
{
    public function showData(Request $request) {
        $product_code = $request->product_code;
        $product_name = $request->product_name;

        $query = ProductModel::query()
            ->select()
            ->from('product')
            ->where('status', '=', 'Y')
            ->when($product_code, function($query, $product_code) {
                return $query->where('product_code','like', '%' .$product_code. '%');
            })
            ->when($product_name, function($query, $product_name) {
                return $query->where('product_name','like', '%' .$product_name. '%');
            })
            ->orderBy('product_code', 'asc')
            ->orderBy('product_name', 'asc');
        
        $data = $query->paginate(30);

        $queryCount = "
            SELECT COUNT(1) AS totalData
            FROM product";

        $total = DB::select($queryCount);

        return view('diskon.index', compact('data', 'total'));
    }

    public function ubahDiskon(Request $request, $id) {

        $request->validate([
            'diskon' => 'required'
        ]);

        $diskon = ProductModel::find($id);
        $diskon->diskon = $request->diskon;
        $diskon->update();

        return redirect()->route('index.diskon')->with('toast_success', 'Data Diskon berhasil diubah!');
    }
}
