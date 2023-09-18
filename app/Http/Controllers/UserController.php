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
            'role' => 'owner'
        ]);

        return redirect('users')->with('success', 'Owner berhasil ditambahkan');
    }

    public function show(User $user)
    {
        return view('users.detail', [
            'title' => 'Detail User',
            'user' => $user,
        ]);
    }

    public function edit(User $user)
    {
        $cities = City::all();

        return view('users.edit', [
            'title' => 'Edit User',
            'user' => $user,
            'cities' => $cities,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required'
        ]);

        if (empty($request->password)) {
            $user->update([
                'name' => $request->name,
                'phone_number' => $request->phone_number
            ]);
        } else {
            $request->validate([
                'password' => 'required|min:5',
                'current_password' => 'required|same:password|min:5'
            ]);

            $user->update([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect('users')->with('success', "Owner {$user->name} berhasil diubah");
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', "Owner {$user->name} berhasil dihapus");
    }
}
