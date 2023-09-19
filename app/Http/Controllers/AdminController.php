<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $auth = auth()->user();
        $city = session('filterKota');
        $users = User::where('role', 'admin')->latest()->whereNotIn('id', [$auth->id]);

        if ($auth->role == 'owner' && !empty($city)) {
            $users = $users->where('city_id', $city);
        }

        return view('admins.index', [
            'title' => 'User',
            'users' => $users->get()
        ]);
    }

    public function create()
    {
        $cities = City::all();

        return view('admins.create', ['title' => 'User Create', 'cities' => $cities]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            // 'email' => 'required|unique:users|email',
            'phone_number' => 'required',
            'password' => 'required',
            'current_password' => 'required|same:password',
            'city_id' => 'required',
        ]);

        if ($request->email) {
            $request->validate([
                'email' => 'unique:sales|email',
            ]);
        }

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'city_id' => $request->city_id,
            'role' => 'admin',
        ]);

        return redirect('admins')->with('success', 'Admin berhasil ditambahkan');
    }

    public function show(User $user)
    {
        return view('admins.detail', [
            'title' => 'Detail User',
            'user' => $user,
        ]);
    }

    public function edit(User $user)
    {
        $cities = City::all();

        return view('admins.edit', [
            'title' => 'Edit User',
            'user' => $user,
            'cities' => $cities,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'city_id' => 'required',
        ]);

        if (empty($request->password)) {
            $user->update([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'city_id' => $request->city_id,
                'active' => $request->active,
            ]);
        } else {
            $request->validate([
                'password' => 'required|min:5',
                'current_password' => 'required|same:password|min:5',
            ]);

            $user->update([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'city_id' => $request->city_id,
                'active' => $request->active,
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect('admins')->with('success', "Data Admin {$user->name} berhasil diubah");
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', "Admin {$user->name} berhasil dihapus");
    }
}
