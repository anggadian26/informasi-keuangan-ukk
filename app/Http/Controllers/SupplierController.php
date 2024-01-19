<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function showData() {
        return view('supplier.index');
    }

    public function addSupplierPage() {
        return view('supplier.addSupplier');
    }
}
