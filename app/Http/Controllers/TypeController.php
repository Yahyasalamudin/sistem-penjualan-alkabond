<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class TypeController extends Controller
{
    public function index()
    {
        $title = 'Jenis Produk';

        $type = Type::get();

        return view('types.index', compact('type', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required'
        ]);

        Type::create([
            'type' => $request->type
        ]);

        return back()->with('success', 'Jenis Produk berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required'
        ]);

        $type = Type::find($id);

        $products = Product::where('product_name', $type->type)->get();
        foreach ($products as $product) {
            $product->update(['product_name' => $request->type]);
        }

        $type->update([
            'type' => $request->type
        ]);

        return redirect('types')->with('success', 'Jenis Produk berhasil diubah');
    }

    public function destroy($id)
    {
        $type = Type::find($id);
        $products = Product::where('product_name', $type->type)->get();

        foreach ($products as $product) {
            $product->delete();
        }

        $type->delete();

        return back()->with('success', 'Jenis Produk berhasil dihapus');
    }
}
