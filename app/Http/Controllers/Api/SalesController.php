<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SalesResource;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sales::latest()->get();

        return response()->json([
            'data' => SalesResource::collection($sales),
            'message' => 'Fetch all Sales',
            'success' => true
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sales_name' => 'required',
            'username' => 'required|unique:sales',
            'phone_number' => 'required|numeric|digits_between:10,14',
            'password' => 'required',
            'city_branch' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $sales = Sales::create([
            'sales_name' => $request->sales_name,
            'username' => $request->username,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'city_branch' => $request->city_branch,
        ]);

        return response()->json([
            'data' => new SalesResource($sales),
            'message' => 'Sales Created successfully',
            'success' => true
        ]);
    }

    public function show(Sales $sales)
    {
        return response()->json([
            'data' => new SalesResource($sales),
            'message' => 'Data Sales found',
            'success' => true
        ]);
    }

    public function update(Request $request, Sales $sales)
    {
        $validator = Validator::make($request->all(), [
            'sales_name' => 'required',
            'phone_number' => 'required|numeric|digits_between:10,14',
            'password' => 'required',
            'city_branch' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $sales->update([
            'sales_name' => $request->sales_name,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'city_branch' => $request->city_branch,
        ]);

        return response()->json([
            'data' => new SalesResource($sales),
            'message' => 'Sales updated successfully',
            'success' => true
        ]);
    }

    public function destroy(Sales $sales)
    {
        $sales->delete();

        return response()->json([
            'data' => new SalesResource($sales),
            'message' => 'Sales Deleted successfully',
            'success' => true
        ]);
    }
}
