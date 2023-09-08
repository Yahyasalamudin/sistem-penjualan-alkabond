<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityBranchResource;
use App\Http\Resources\StoreResource;
use App\Models\CityBranch;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    public function index()
    {
        $store = Store::where('sales_id', auth()->user()->id)->get();
        $city_branch = CityBranch::where('city_id', auth()->user()->city_id)->get();

        return response()->json([
            'data' => ['stores' => StoreResource::collection($store), 'city_branches' => CityBranchResource::collection($city_branch)],
            'message' => 'Fetch Store and City Branch',
            'status_code' => 200
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'store_name' => 'required',
        ];

        if (!empty($request->store_number)) {
            $rules['store_number'] = 'numeric|digits_between:10,14';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'status_code' => 403
            ]);
        }

        $store = Store::create([
            'store_name' => $request->store_name,
            'address' => $request->address,
            'store_number' => $request->store_number,
            'city_id' => auth()->user()->city_id,
            'city_branch_id' => $request->city_branch_id,
            'sales_id' => auth()->user()->id
        ]);

        return response()->json([
            'data' => new StoreResource($store),
            'message' => 'Store Created successfully',
            'status_code' => 200
        ]);
    }
}
