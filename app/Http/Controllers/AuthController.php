<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:5|max:255|unique:users|unique:sales',
            'email' => 'required|string|email|max:255|unique:users|unique:sales',
            'phone_number' => 'required|numeric|digits_between:10,14',
            'password' => 'required|string|min:8'
        ]);

        if($request->role == '') {
            Sales::create([
                'sales_name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
            ]);
        } else {
            $request->validate([
                'role' => 'required'
            ]);

            Sales::create([
                'sales_name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect('login')->with('success', 'akun berhasil didaftarkan');
    }

    public function login() {
        if(Auth::check()) {
            return redirect('dasboard');
        } else {
            return view('auth.login');
        }
    }

    public function actionLogin(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        if (Auth::attempt($data))
        {
            if(auth()->user()->role == 'owner') {
                return ('owner');
            } else {
                return ('admin');
            }
        } else if (Auth::guard('sales')->attempt($data))
        {
            return ('sales');
        } else {
            return redirect()->back()->with('error', 'email atau password salah');
        }
    }
}
