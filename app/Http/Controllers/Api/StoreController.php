<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    public function index()
    {
        $store = Store::where('sales_id', auth()->user()->id)->latest()->get();

        return response()->json([
            'data' => StoreResource::collection($store),
            'message' => 'Fetch all Store',
            'status_code' => 200
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store_name' => 'required',
            'address' => 'required',
            'store_number' => 'required|numeric|digits_between:10,14'
        ]);

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
            'city_branch' => auth()->user()->city,
            'sales_id' => auth()->user()->id
        ]);

        return response()->json([
            'data' => new StoreResource($store),
            'message' => 'Store Created successfully',
            'status_code' => 200
        ]);
    }
}
