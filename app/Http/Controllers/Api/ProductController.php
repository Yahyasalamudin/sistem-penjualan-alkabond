<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::latest()->get();

        return response()->json([
            'data' => ProductResource::collection($product),
            'message' => 'Fetch all Product',
            'success' => true
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'product_brand' => 'required',
            'unit_id' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $now = Carbon::now();
        $date = date('Ym', strtotime($now));
        $check = Product::count();
        if($check == 0){
            $code = 10000001;
            $product_code = 'BRG' . $date . $code;
        } else {
            $query = Product::all()->last();
            $code = (int)substr($query->product_code, -8) + 1;
            $product_code = 'BRG' . $date . $code;
        }

        $product = Product::create([
            'product_code' => $product_code,
            'product_name' => $request->product_name,
            'product_brand' => $request->product_brand,
            'unit_id' => $request->unit_id,
        ]);

        return response()->json([
            'data' => new ProductResource($product),
            'message' => 'Product Created successfully',
            'success' => true
        ]);
    }

    public function show(Product $product)
    {
        return response()->json([
            'data' => new ProductResource($product),
            'message' => 'Data Product found',
            'success' => true
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'product_brand' => 'required',
            'unit_id' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $product->update([
            'product_name' => $request->product_name,
            'product_brand' => $request->product_brand,
            'unit_id' => $request->unit_id
        ]);

        return response()->json([
            'data' => new ProductResource($product),
            'message' => 'Product updated successfully',
            'success' => true
        ]);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'data' => new ProductResource($product),
            'message' => 'Product Deleted successfully',
            'success' => true
        ]);
    }
}
