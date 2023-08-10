<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SalesController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $city = session('filterKota');

        $sales = Sales::where(function ($query) use ($city, $user) {
            if ($user->role == 'owner' && !empty($city)) {
                $query->where('city', $city);
            } elseif ($user->rol == 'admin') {
                $query->where('city', $user->city);
            }
        })->get();

        return view('sales.index', [
            'title' => 'Sales',
            'sales' => $sales
        ]);
    }

    public function create()
    {
        $cities = City::all();

        return view('sales.create', ['title' => 'Sales Create', 'cities' => $cities]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'sales_name' => 'required',
            'username' => 'required|unique:sales',
            'phone_number' => 'required',
            'password' => 'required',
            'current_password' => 'required|same:password',
            'city' => 'required'
        ]);

        if ($request->email) {
            $request->validate([
                'email' => 'unique:sales|email',
            ]);
        }

        Sales::create([
            'sales_name' => $request->sales_name,
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'city' => $request->city
        ]);

        return redirect('sales')->with('success', 'Sales berhasil ditambahkan');
    }

    public function show($id)
    {
        $sales = Sales::find($id);

        return view('sales.detail', [
            'title' => 'Detail Sales',
            'sales' => $sales,
        ]);
    }

    public function edit($id)
    {
        $sales = Sales::find($id);
        $cities = City::all();

        return view('sales.edit', [
            'title' => 'Edit Sales',
            'sales' => $sales,
            'cities' => $cities,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sales_name' => 'required',
            'phone_number' => 'required',
            'city' => 'required',
        ]);

        if (empty($request->password)) {
            Sales::find($id)->update([
                'sales_name' => $request->sales_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'city' => $request->city,
                'active' => $request->active,
            ]);
        } else {
            $request->validate([
                'password' => 'required|min:6',
                'current_password' => 'required|same:password|min:6',
            ]);

            Sales::find($id)->update([
                'sales_name' => $request->sales_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'city' => $request->city,
                'active' => $request->active,
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect('sales')->with('success', 'Informasi Sales berhasil diubah');
    }

    public function destroy($id)
    {
        Sales::find($id)->delete();

        return back()->with('success', 'Sales berhasil dihapus');
    }
}