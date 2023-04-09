<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login() {
        if(Auth::check()) {
            return redirect('dasboard');
        } else {
            return view('login');
        }
    }

    public function processLogin() {
        // Http::get()
    }
}
