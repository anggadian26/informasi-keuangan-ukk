<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index() 
    {
        return view('auth.login');
    }

    public function loginAction(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);


        if(Auth::attempt($credentials)) {
            $user = Auth::user();
            return redirect()->intended('/');
        }
        
        return back()->with('loginError', 'Login failed!');
    }

    public function logOut() {
        Auth::logout();
        return redirect()->route('login');
    }
}
