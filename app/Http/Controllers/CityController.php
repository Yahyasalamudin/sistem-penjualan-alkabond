<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $city = City::get();

        $title = 'Data Kota';

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

        return back()->with('success', 'Kota berhasil ditambahkan');
    }

    public function edit(City $city)
    {
        dd($city);
        Crypt::decrypt($city);
        $city = City::find($city);

        return view('cities.edit', compact('city'));
    }

    public function update(Request $request, City $city)
    {
        $request->validate([
            'city' => 'required|regex:/^[a-zA-Z\s]*$/|unique:cities'
        ], [
            'city.regex' => 'Nama Kota tidak boleh berupa angka'
        ]);

        $city->update([
            'city' => $request->city
        ], [
            'city' => 'Nama Kota tidak boleh berupa angka'
        ]);

        return redirect('cities')->with('success', 'Kota berhasil diubah');
    }

    public function destroy(City $city)
    {
        $city->delete();

        return back()->with('success', 'Kota berhasil dihapus');
    }
}
