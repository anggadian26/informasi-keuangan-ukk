<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReturnBarangController extends Controller
{
    public function showData()
    {
        return view('return-barang.index');
    }
}
