<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Sales;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::latest()->get();
        $sales = Sales::get();

        if (auth()->user()->role == 'admin') {
            $sales = Sales::where('city', auth()->user()->city)->get();
        }

        return view('stores.index', compact('stores', 'sales'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'store_name' => 'required|max:255',
            'address' => 'required|max:255',
            'store_number' => 'required|numeric|digits_between:10,14',
            'sales_id' => 'required',
        ]);

        $sales = Sales::find($request->sales_id);

        Store::create([
            'store_name' => $request->store_name,
            'address' => $request->address,
            'store_number' => $request->store_number,
            'sales_id' => $request->sales_id,
            'city_branch' => $sales->city
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
        $store = DB::table('stores')
            ->where('stores.id', $id)
            ->join('sales', 'stores.sales_id', 'sales.id')
            ->select('stores.*', 'sales.sales_name')
            ->first();

        $sales = Sales::where('city', $store->city_branch)->whereNotIn('id', [$store->sales_id])->get();

        return view('stores.edit', compact('store', 'sales'));
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
