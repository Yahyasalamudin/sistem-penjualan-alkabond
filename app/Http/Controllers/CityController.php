<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Sales;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CityController extends Controller
{
    public function index()
    {
        $title = 'Data Kota';

        $city = City::get();

        return view('cities.index', compact('city', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'city' => 'required|string|regex:/^[a-zA-Z\s]*$/|unique:cities'
        ], [
            'city.regex' => 'Kota tidak boleh berupa angka'
        ]);

        City::create([
            'city' => $request->city
        ]);

        return back()->with('success', 'Kota berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'city' => 'required|regex:/^[a-zA-Z\s]*$/|unique:cities'
        ], [
            'city.regex' => 'Kota tidak boleh berupa angka'
        ]);

        $city = City::find($id);

        $users = User::where('city', $city->city)->get();
        foreach ($users as $user) {
            $user->update(['city' => $request->city]);
        }

        $sales = Sales::where('city', $city->city)->get();
        foreach ($sales as $s) {
            $s->update(['city' => $request->city]);
        }

        $stores = Store::where('city_branch', $city->city)->get();
        foreach ($stores as $store) {
            $store->update(['city_branch' => $request->city]);
        }

        $city->update([
            'city' => $request->city
        ]);

        return redirect('cities')->with('success', 'Kota berhasil diubah');
    }

    public function destroy($id)
    {
        City::find($id)->delete();

        return back()->with('success', 'Kota berhasil dihapus');
    }
}
