<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Sales;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $store = Store::latest()->get();
        $sales = Sales::get();
        $city = City::get();

        return view('store.index', compact('store', 'city', 'sales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'store_name' => 'required|max:255',
            'address' => 'required|max:255',
            'phone_number' => 'required|numeric|digits_between:10,14',
            'sales_id' => 'required',
            'city_branch' => 'required'
        ]);

        Store::create([
            'store_name' => $request->store_name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'sales_id' => $request->sales_id,
            'city_branch' => $request->city_branch
        ]);

        return back()->with('success', 'Toko Berhasil ditambahkan');
    }

    public function show(Store $store)
    {
        return view('store.detail', compact('store'));
    }

    public function edit(Store $store)
    {
        $sales = Sales::get();
        $city = City::get();

        return view('store.edit', compact('store', 'city', 'sales'));
    }

    public function update(Request $request, Store $store)
    {
        $request->validate([
            'store_name' => 'required|max:255',
            'address' => 'required|max:255',
            'phone_number' => 'required|numeric|digits_between:10,14',
            'sales_id' => 'required'
        ]);

        $store->update([
            'store_name' => $request->store_name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'sales_id' => $request->sales_id,
        ]);

        return redirect('store')->with('success', 'Data Toko berhasil diubah');
    }

    public function destroy(Store $store)
    {
        $store->delete();

        return back()->with('success', 'Data Toko telah dihapus');
    }
}
