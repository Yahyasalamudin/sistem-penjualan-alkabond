<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProductResource;
use App\Http\Resources\TypeResource;
use App\Models\Product;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->type == null) {
            $products = Product::latest()->get();
        } else {
            $products = Product::where('product_name', $request->type)->latest()->get();
        }

        return response()->json([
            'data' => ProductResource::collection($products),
            'message' => 'Fetch all products',
            'status_code' => 200
        ]);
    }

    public function getProductTypes()
    {
        $products = Product::all();
        $productNames = $products->pluck('product_name')->toArray();

        $types = Type::whereIn('type', $productNames)->get();

        return response()->json([
            'data' => TypeResource::collection($types),
            'message' => 'Fetch all types',
            'status_code' => 200
        ]);
    }
}
