<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $city = City::latest()->get();

        return response()->json([
            'data' => CityResource::collection($city),
            'message' => 'Fetch all Product',
            'success' => true
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $city = City::create([
            'city' => $request->city,
        ]);

        return response()->json([
            'data' => new CityResource($city),
            'message' => 'Product Created successfully',
            'success' => true
        ]);
    }

    public function show(City $city)
    {
        return response()->json([
            'data' => new CityResource($city),
            'message' => 'Data Product found',
            'success' => true
        ]);
    }

    public function update(Request $request, City $city)
    {
        $validator = Validator::make($request->all(), [
            'city' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $city->update([
            'city' => $request->city,
        ]);

        return response()->json([
            'data' => new CityResource($city),
            'message' => 'Product Deleted successfully',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $city->delete();

        return response()->json([
            'data' => new CityResource($city),
            'message' => 'Product Deleted successfully',
            'success' => true
        ]);
    }
}
