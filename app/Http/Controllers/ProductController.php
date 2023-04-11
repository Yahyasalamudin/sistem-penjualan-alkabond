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
        $products = Product::latest()->get();

        $type = Type::get();

        return view('products.index', compact('products', 'type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'product_brand' => 'required',
            'unit_weight' => 'required',
        ]);

        $words = explode(" ", $request->product_name);
        $output = "";
        foreach ($words as $word) {
            $output .= substr($word, 0, 1);
        }

        $now = Carbon::now();
        $date = date('Ym', strtotime($now));
        $check = Product::count();
        if ($check == 0) {
            $code = 100001;
            $product_code = $output . $date . $code;
        } else {
            $query = Product::all()->last();
            $code = (int)substr($query->product_code, -6) + 1;
            $product_code = $output . $date . $code;
        }

        Product::create([
            'product_code' => $product_code,
            'product_name' => $request->product_name,
            'product_brand' => $request->product_brand,
            'unit_weight' => $request->unit_weight
        ]);

        return back()->with('success', 'Data Produk telah berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $type = Type::get();

        return view('products.edit', compact('product', 'type', 'unit'));
    }

    // public function update(Request $request, Product $product)
    // {
    //     $request->validate([
    //         'product_name' => 'required',
    //         'product_brand' => 'required',
    //         'unit_id' => 'required',
    //     ]);

    //     $product->update([
    //         'product_name' => $request->product_name,
    //         'product_brand' => $request->product_brand,
    //         'unit_id' => $request->unit_id,
    //     ]);

    //     return redirect('product')->with('success', 'Data Produk berhasil diubah');
    // }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('success', 'Data Produk berhasil dihapus');
    }
}
