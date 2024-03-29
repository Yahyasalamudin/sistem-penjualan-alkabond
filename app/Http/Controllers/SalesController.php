<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\CityBranch;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SalesController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $city = session('filter-city');
        $city_branch = session('filter-city-branch');

        $sales = Sales::filterCity($user, $city)->filterBranch($city_branch)->get();

        return view('sales.index', [
            'title' => 'Sales',
            'sales' => $sales
        ]);
    }

    public function create()
    {
        $user = auth()->user();
        $cities = City::when($user->role == 'admin', function ($query) use ($user) {
            $query->where('id', $user->city_id);
        })->get();
        $city_branches = CityBranch::where('city_id', $user->city_id)->get();

        return view('sales.create', [
            'title' => 'Sales Create',
            'cities' => $cities,
            'city_branches' => $city_branches,
            'user' => $user
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'sales_name' => 'required',
            'username' => 'required|unique:sales',
            'phone_number' => 'required',
            'password' => 'required',
            'current_password' => 'required|same:password',
            'city_id' => 'required',
            'city_branch_id' => 'required'
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
            'city_id' => $request->city_id,
            'city_branch_id' => $request->city_branch_id
        ]);

        return redirect('sales')->with('success', 'Sales berhasil ditambahkan');
    }

    public function show(Sales $sales)
    {
        return view('sales.detail', [
            'title' => 'Detail Sales',
            'sales' => $sales,
        ]);
    }

    public function edit(Sales $sales)
    {
        $user = auth()->user();
        $cities = City::all();
        $city_branches = CityBranch::where('city_id', $sales->city_id)->get();

        return view('sales.edit', [
            'title' => 'Edit Sales',
            'sales' => $sales,
            'user' => $user,
            'cities' => $cities,
            'city_branches' => $city_branches,
        ]);
    }

    public function update(Request $request, Sales $sales)
    {
        $request->validate([
            'sales_name' => 'required',
            'phone_number' => 'required',
            'city_id' => 'required',
            'city_branch_id' => 'required',
        ]);

        if (empty($request->password)) {
            $sales->update([
                'sales_name' => $request->sales_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'city_id' => $request->city_id,
                'city_branch_id' => $request->city_branch_id,
                'active' => $request->active,
            ]);
        } else {
            $request->validate([
                'password' => 'required|min:5',
                'current_password' => 'required|same:password|min:5',
            ]);

            $sales->update([
                'sales_name' => $request->sales_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'city_id' => $request->city_id,
                'city_branch_id' => $request->city_branch_id,
                'active' => $request->active,
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect('sales')->with('success', "Data Sales {$sales->sales_name} berhasil diubah");
    }

    public function destroy(Sales $sales)
    {
        $sales->delete();

        return back()->with('success', "Sales {$sales->sales_name} berhasil dihapus");
    }
}
