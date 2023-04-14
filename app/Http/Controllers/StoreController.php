<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Sales;
use App\Models\Store;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::latest()->get();
        $sales = Sales::get();
        $city = City::get();

        return view('stores.index', compact('stores', 'city', 'sales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'store_name' => 'required|max:255',
            'address' => 'required|max:255',
            'store_number' => 'required|numeric|digits_between:10,14',
            'sales_id' => 'required',
            'city_branch' => 'required'
        ]);

        Store::create([
            'store_name' => $request->store_name,
            'address' => $request->address,
            'store_number' => $request->store_number,
            'sales_id' => $request->sales_id,
            'city_branch' => $request->city_branch
        ]);

        return back()->with('success', 'Toko Berhasil ditambahkan');
    }

    public function show($id)
    {
        $store = Store::find($id);

        return view('stores.detail', compact('store'));
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $store = Store::find($id);

        $sales = Sales::get();
        $city = City::get();

        return view('stores.edit', compact('store', 'city', 'sales'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'store_name' => 'required|max:255',
            'address' => 'required|max:255',
            'store_number' => 'required|numeric|digits_between:10,14',
            'sales_id' => 'required'
        ]);

        Store::find($id)->update([
            'store_name' => $request->store_name,
            'address' => $request->address,
            'store_number' => $request->store_number,
            'sales_id' => $request->sales_id,
        ]);

        return redirect('stores')->with('success', 'Data Toko berhasil diubah');
    }

    public function destroy($id)
    {
        Store::find($id)->delete();

        return back()->with('success', 'Data Toko telah dihapus');
    }
}
