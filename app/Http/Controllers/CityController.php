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
        $title = 'Data Cabang Gudang';

        $city = City::get();

        return view('cities.index', compact('city', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'city' => 'required|string|unique:cities'
        ]);

        City::create([
            'city' => $request->city
        ]);

        return back()->with('success', 'Cabang berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'city' => 'required|unique:cities'
        ]);

        $city = City::find($id);

        $city->update([
            'city' => $request->city
        ]);

        return redirect('cities')->with('success', 'Cabang berhasil diubah');
    }

    public function destroy($id)
    {
        City::find($id)->delete();

        return back()->with('success', 'Cabang berhasil dihapus');
    }
}
