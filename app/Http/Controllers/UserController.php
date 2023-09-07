<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $auth = auth()->user();
        $users = User::where('role', 'owner')->latest()->whereNotIn('id', [$auth->id])->whereNotIn('username', ['tester'])->get();

        return view('users.index', [
            'title' => 'User',
            'users' => $users
        ]);
    }

    public function create()
    {
        $cities = City::all();

        return view('users.create', ['title' => 'User Create', 'cities' => $cities]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
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
            'role' => 'owner'
        ]);

        return redirect('users')->with('success', 'User berhasil ditambahkan');
    }

    public function show($id)
    {
        $user = User::find($id);

        return view('users.detail', [
            'title' => 'Detail User',
            'user' => $user,
        ]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        $cities = City::all();

        return view('users.edit', [
            'title' => 'Edit User',
            'user' => $user,
            'cities' => $cities,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'city_id' => 'required',
        ]);

        if (empty($request->password)) {
            User::find($id)->update([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'city_id' => $request->city_id,
            ]);
        } else {
            $request->validate([
                'password' => 'required|min:5',
                'current_password' => 'required|same:password|min:5',
            ]);

            User::find($id)->update([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'city_id' => $request->city_id,
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect('users')->with('success', 'Informasi User berhasil diubah');
    }

    public function destroy($id)
    {
        User::find($id)->delete();

        return back()->with('success', 'Pengguna berhasil dihapus');
    }
}
