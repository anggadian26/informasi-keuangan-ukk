<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function showData(Request $request) 
    {
        return view("member.index");
    }

    public function addPage() {
        return view("member.addMember");
    }
}
