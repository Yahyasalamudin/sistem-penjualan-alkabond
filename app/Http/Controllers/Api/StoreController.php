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
        $store = Store::latest()->get();

        return response()->json([
            'data' => StoreResource::collection($store),
            'message' => 'Fetch all Store',
            'success' => true
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store_name' => 'required',
            'address' => 'required',
            'phone_number' => 'required|numeric|digits_between:10,14',
            'sales_id' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $store = Store::create([
            'store_name' => $request->store_name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'sales_id' => $request->sales_id,
        ]);

        return response()->json([
            'data' => new StoreResource($store),
            'message' => 'Store Created successfully',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        return response()->json([
            'data' => new StoreResource($store),
            'message' => 'Data Store found',
            'success' => true
        ]);
    }

    public function update(Request $request, Store $store)
    {
        $validator = Validator::make($request->all(), [
            'store_name' => 'required',
            'address' => 'required',
            'phone_number' => 'required|numeric|digits_between:10,14',
            'sales_id' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $store->update([
            'store_name' => $request->store_name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'sales_id' => $request->sales_id,
        ]);

        return response()->json([
            'data' => new StoreResource($store),
            'message' => 'Store Updated successfully',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        $store->delete();

        return response()->json([
            'data' => new StoreResource($store),
            'message' => 'Store Deleted successfully',
            'success' => true
        ]);
    }
}
