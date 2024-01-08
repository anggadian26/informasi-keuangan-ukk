<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubCtgrProductController extends Controller
{
    public function index()
    {
        return view('sub-ctgr-product.index');
    }
}
