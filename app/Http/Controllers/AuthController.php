<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\User;
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
            'password' => 'required|string|min:6'
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

            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'role' => $request->role
            ]);
        }

        return redirect('login')->with('success', 'akun berhasil didaftarkan');
    }

    public function login() {
        if(Auth::check()) {
            return redirect('dashboard');
        } else {
            // dd('test');
            return view('auth.login');
        }
    }

    public function actionLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt($request->only('email', 'password')))
        {
            if(auth()->user()->role == 'owner') {
                return view('owner.index')->with('success', 'Selamat Datang ');
            } else {
                return view('admin.index')->with('success', 'Selamat Datang ');
            }
        } else if (Auth::guard('sales')->attempt($request->only('email', 'password'))) {
            return view('sales')->with('success', 'Selamat Datang ');
        }

        return redirect()->back()->with('error', 'Email atau Password Salah');

    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
}
