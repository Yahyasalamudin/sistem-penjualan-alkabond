<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TypeResource;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type = Type::latest()->get();

        return response()->json([
            'data' => TypeResource::collection($type),
            'message' => 'Fetch all Type',
            'success' => true
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $type = Type::create([
            'type' => $request->type,
        ]);

        return response()->json([
            'data' => new TypeResource($type),
            'message' => 'Type created successfully.',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        return response()->json([
            'data' => new TypeResource($type),
            'message' => 'Data Type found',
            'success' => true
        ]);
    }

    public function update(Request $request, Type $type)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $type->update([
            'type' => $request->type
        ]);

        return response()->json([
            'data' => new TypeResource($type),
            'message' => 'Type updated successfully',
            'success' => true
        ]);
    }

    public function destroy(Type $type)
    {
        $type->delete();

        return response()->json([
            'data' => new TypeResource($type),
            'message' => 'Type Deleted successfully',
            'success' => true
        ]);
    }
}
