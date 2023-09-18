<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $title = 'Product';

        $products = Product::get();
        $type = Type::get();

        return view('products.index', compact('title', 'products', 'type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_code' => 'required',
            'product_name' => 'required',
            'product_brand' => 'required',
            'unit_weight' => 'required',
        ]);

        Product::create([
            'product_code' => $request->product_code,
            'product_name' => $request->product_name,
            'product_brand' => $request->product_brand,
            'unit_weight' => $request->unit_weight
        ]);

        return back()->with('success', 'Data Produk telah berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_code' => 'required',
            'product_name' => 'required',
            'product_brand' => 'required',
            'unit_weight' => 'required',
        ]);

        $product = Product::find($id);

        $product->update([
            'product_code' => $request->product_code,
            'product_name' => $request->product_name,
            'product_brand' => $request->product_brand,
            'unit_weight' => $request->unit_weight,
        ]);

        return back()->with('success', 'Data Produk berhasil diedit');
    }

    public function destroy($id)
    {
        Product::find($id)->delete();

        return back()->with('success', 'Data Produk berhasil dihapus');
    }
}
