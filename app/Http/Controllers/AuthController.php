<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:5|max:255|unique:users|unique:sales',
            'email' => 'required|string|email|max:255|unique:users|unique:sales',
            'phone_number' => 'required|numeric|digits_between:10,14',
            'password' => 'required|string|min:6'
        ]);

        if ($request->role == '') {
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

    public function login()
    {
        if (Auth::check()) {
            return redirect('dashboard');
        } else {
            return view('auth.login');
        }
    }

    public function actionLogin(Request $request)
    {
        $request->validate([
            'email_username' => 'required',
            'password' => 'required|min:5'
        ]);

        $email = $request->email_username;
        $user = User::where(function ($query) use ($email) {
            $query->where('email', $email)
                ->orWhere('username', $email);
        })->first();

        if (isset($user) && $user->role == 'admin' && $user->active == 0) {
            return back()->with('error', 'Akun anda telah dinonaktifkan oleh owner');
        }

        $credentials = $request->only('email_username', 'password');

        if (Auth::attempt(['email' => $credentials['email_username'], 'password' => $credentials['password']], $request->remember) || Auth::attempt(['username' => $credentials['email_username'], 'password' => $credentials['password']], $request->remember)) {
            return redirect('dashboard');
        } else {
            $email = User::where('email', $credentials['email_username'])->first();
            $username = User::where('username', $credentials['email_username'])->first();
            if ($email || $username) {
                return back()->with('error', 'Password yang anda masukkan salah!!');
            } else {
                return back()->with('error', 'Email atau Username tidak ditemukan!!');
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        session(['filter-city' => ""]);
        session(['filter-city-branch' => ""]);
        return redirect('/login')->withCookie(Cookie::forget('remember_token'));
    }
}
