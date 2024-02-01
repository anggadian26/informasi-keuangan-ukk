<?php

namespace App\Http\Controllers;

use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function showData(Request $request) {
        $supplier_name = $request->supplier_name;
        $supplier_company = $request->supplier_company;
        $status = $request->status; 

        $query = SupplierModel::query()
            ->select("*")
            ->from("supplier")
            ->when($supplier_name, function($query, $supplier_name) {
                $query->where("supplier_name","like","%".$supplier_name."%");
            })
            ->when($supplier_company, function($query, $supplier_company) {
                $query->where("supplier_company","like","%".$supplier_company."%");
            })
            ->when( $status, function($query, $status) {
                $query->where("status", $status);
            })
            ->orderBy("supplier_company")
            ->orderBy("supplier_name")
        ;

        $supplier = $query->paginate(50);

        $queryCount = "
            SELECT COUNT(1) AS totalData
            FROM supplier    
        ";

        $total = DB::select($queryCount);

        return view('supplier.index', compact(['supplier', 'total']));
    }

    public function addSupplierPage() {
        return view('supplier.addSupplier');
    }

    public function addSupplierAction(Request $request) 
    { 
        $val = $request->validate([
            'supplier_name'         => 'required',
            'phone_number_person'   => 'required',
            'email_person'          => 'required',
            'supplier_company'      => 'required',
            'phone_number_company'  => 'required',
            'address_company'       => 'required'
        ]);

        $data = [
            'supplier_name'         => $val['supplier_name'],
            'phone_number_person'   => $val['phone_number_person'],
            'email_person'          => $val['email_person'],
            'supplier_company'      => $val['supplier_company'],
            'phone_number_company'  => $val['phone_number_company'],
            'address_company'       => $val['address_company'],
            'status'                => 'Y',
        ];

        SupplierModel::create($data);

        return redirect()->route('index.supplier')->with('toast_success', 'Supplier berhasil ditambahkan!');
    }

    public function editSupplierPage($id)
    {
        $supplier = SupplierModel::find($id);
        return view('supplier.editSupplier', compact(['supplier']));
    }

    public function editSupplierAction(Request $request, $id) 
    {
        $val = $request->validate([
            'supplier_name'         => 'required',
            'phone_number_person'   => 'required',
            'email_person'          => 'required',
            'supplier_company'      => 'required',
            'phone_number_company'  => 'required',
            'address_company'       => 'required',
            'status'                => 'required',
        ]);

        $supplier = SupplierModel::find($id);

        $supplier->update([
            'supplier_name'             => $val['supplier_name'],
            'phone_number_person'       => $val['phone_number_person'],
            'email_person'              => $val['email_person'],
            'supplier_company'          => $val['supplier_company'],
            'phone_number_company'      => $val['phone_number_company'],
            'address_company'           => $val['address_company'],
            'status'                    => $val['status'],
        ]);

        return redirect()->route('index.supplier')->with('toast_success', 'Supplier berhasil diubah!');
    }
}
