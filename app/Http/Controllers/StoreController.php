<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Sales;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function index()
    {
        $title = 'Daftar Toko';

        $user = auth()->user();
        $city = session('filterKota');
        $city_branch = session('filterCabangKota');

        $stores = Store::filterCity($user, $city, $city_branch)->get();

        $today = Carbon::today();
        foreach ($stores as $key => $store) {
            $latest_transaction = $store->transactions->min('created_at');
            $stores[$key]['last_transaction_date'] = $latest_transaction;
            $stores[$key]['is_more_than_60_days'] = $latest_transaction ? $latest_transaction->diffInDays($today) > 60 : false;
        }

        $stores = $stores->sortBy(function ($store) {
            return $store['last_transaction_date'] ?? Carbon::now()->addYears(100);
        });

        $sales = Sales::filterCity($user, $city)->get();

        return view('stores.index', compact('title', 'stores', 'sales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'store_name' => 'required|max:255',
            'address' => 'required|max:255',
            'sales_id' => 'required',
            'city_branch_id' => 'required',
            'store_number' => 'sometimes|numeric|digits_between:10,14',
        ]);

        $sales = Sales::find($request->sales_id);

        Store::create([
            'store_name' => $request->store_name,
            'address' => $request->address,
            'store_number' => $request->store_number,
            'sales_id' => $request->sales_id,
            'city_id' => $sales->city_id,
            'city_branch_id' => $sales->city_branch_id
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

        $sales = Sales::where('city_id', $store->city_id)->whereNotIn('id', [$store->sales_id])->get();

        return view('stores.edit', compact('store', 'sales'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'store_name' => 'required|max:255',
            'address' => 'required|max:255',
            'store_number' => 'sometimes|digits_between:10,14',
            'sales_id' => 'required'
        ]);

        $sales = Sales::find($request->sales_id);

        Store::find($id)->update([
            'store_name' => $request->store_name,
            'address' => $request->address,
            'store_number' => $request->store_number,
            'sales_id' => $request->sales_id,
            'city_id' => $sales->city_id,
            'city_branch_id' => $sales->city_branch_id
        ]);

        return redirect('stores')->with('success', 'Data Toko berhasil diubah');
    }

    public function destroy($id)
    {
        Store::find($id)->delete();

        return back()->with('success', 'Data Toko telah dihapus');
    }
}
