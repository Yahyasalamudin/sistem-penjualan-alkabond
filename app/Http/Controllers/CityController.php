<?php

namespace App\Http\Controllers;

use App\Models\City;
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
            'city' => 'required|string|unique:cities'
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
            'city.regex' => 'Nama Kota tidak boleh berupa angka'
        ]);

        City::find($id)->update([
            'city' => $request->city
        ]);

        // [
        //     'city' => 'Nama Kota tidak boleh berupa angka'
        // ]

        return redirect('cities')->with('success', 'Kota berhasil diubah');
    }

    public function destroy($id)
    {
        City::find($id)->delete();

        return back()->with('success', 'Kota berhasil dihapus');
    }
}
