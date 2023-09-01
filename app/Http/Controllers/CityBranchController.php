<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\CityBranch;
use App\Models\Sales;
use Illuminate\Http\Request;

class CityBranchController extends Controller
{
    public function index()
    {
        $title = 'Data Cabang Kota';
        $city = session('filterKota');

        $cities = City::get();
        $city_branches = CityBranch::when($city, function ($query) use ($city) {
            $query->where('city_id', $city);
        })->get();

        return view('city-branches.index', compact('cities', 'city_branches', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'city_id' => 'required',
            'branch' => 'required|string|regex:/^[a-zA-Z\s]*$/'
        ], [
            'branch.regex' => 'Cabang Kota tidak boleh berupa angka'
        ]);

        CityBranch::create([
            'city_id' => $request->city_id,
            'branch' => $request->branch
        ]);

        return back()->with('success', 'Cabang Kota berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'city_id' => 'required',
            'branch' => 'required|string|regex:/^[a-zA-Z\s]*$/'
        ], [
            'branch.regex' => 'Cabang Kota tidak boleh berupa angka'
        ]);

        $city_branch = CityBranch::find($id);

        $city_branch->update([
            'city_id' => $request->city_id,
            'branch' => $request->branch
        ]);

        return back()->with('success', 'Cabang Kota berhasil diubah');
    }

    public function destroy($id)
    {
        CityBranch::find($id)->delete();

        return back()->with('success', 'Cabang Kota berhasil dihapus');
    }

    public function get_city_branches(Request $request, $id)
    {
        if ($request->sales) {
            $sales = Sales::find($id);
            $id = $sales->city_id;
        }

        $city_branches = CityBranch::where('city_id', $id)
            ->get();

        return response()->json($city_branches);
    }
}
