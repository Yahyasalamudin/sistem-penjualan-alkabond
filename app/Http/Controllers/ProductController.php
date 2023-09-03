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

        // $words = explode(" ", $request->product_name);
        // $output = "";
        // foreach ($words as $word) {
        //     $output .= substr($word, 0, 1);
        // }

        // $now = Carbon::now();
        // $date = date('Ym', strtotime($now));
        // $check = Product::count();
        // if ($check == 0) {
        //     $code = 10001;
        //     $product_code = $output . $code;
        // } else {
        //     $query = Product::all()->last();
        //     $code = (int) substr($query->product_code, -5) + 1;
        //     $product_code = $output . $code;
        // }

        Product::create([
            'product_code' => $request->product_code,
            'product_name' => $request->product_name,
            'product_brand' => $request->product_brand,
            'unit_weight' => $request->unit_weight
        ]);

        return back()->with('success', 'Data Produk telah berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $products = Product::find($id);
        $type = Type::get();

        return view('products.edit', compact('products', 'type', 'unit'));
    }

    // public function update(Request $request, $id)
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

    public function destroy($id)
    {
        Product::find($id)->delete();

        return back()->with('success', 'Data Produk berhasil dihapus');
    }
}
