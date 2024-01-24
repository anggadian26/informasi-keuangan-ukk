<?php

namespace App\Http\Controllers;

use App\Models\PembelianModel;
use App\Models\SupplierModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    public function showData(Request $request)
    {
        $supplier = SupplierModel::all();
        return view('pembelian.index', compact('supplier'));
    }

    public function searchSupplier(Request $request)
    {
        $searchTerm = $request->input('searchTerm');

        $supplier = SupplierModel::where('supplier_name', 'like', "%$searchTerm%")
            ->get();

        return response()->json(['supplier' => $supplier]);
    }

    public function transactionPage($id)
    {
        $supplier = SupplierModel::find($id);

        return view('pembelian.transactionPage', compact('supplier'));
    }
}
