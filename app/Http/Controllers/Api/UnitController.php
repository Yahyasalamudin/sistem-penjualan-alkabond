<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UnitResource;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
    public function index()
    {
        $unit = Unit::latest()->get();

        return response()->json([
            'data' => UnitResource::collection($unit),
            'message' => 'Fetch all unit',
            'success' => true
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unit_name' => 'required',
            'amount' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $unit = Unit::create([
            'unit_name' => $request->unit_name,
            'amount' => $request->amount,
        ]);

        return response()->json([
            'data' => new UnitResource($unit),
            'message' => 'Unit created successfully.',
            'success' => true
        ]);
    }

    public function show(Unit $unit)
    {
        return response()->json([
            'data' => new UnitResource($unit),
            'message' => 'Data Unit found',
            'success' => true
        ]);
    }

    public function update(Request $request, Unit $unit)
    {
        $validator = Validator::make($request->all(), [
            'unit_name' => 'required|string|max:155',
            'amount' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $unit->update([
            'unit_name' => $request->unit_name,
            'amount' => $request->amount,
        ]);

        return response()->json([
            'data' => new UnitResource($unit),
            'message' => 'Unit updated successfully',
            'success' => true
        ]);
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();

        return response()->json([
            'data' => [],
            'message' => 'Unit deleted successfully',
            'success' => true
        ]);
    }
}
