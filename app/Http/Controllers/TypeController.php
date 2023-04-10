<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function index()
    {
        $type = Type::get();

        $title = 'Jenis Produk';

        return view('type.index', compact('type', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required'
        ]);

        Type::create([
            'type' => $request->type
        ]);

        return redirect()->back()->with('success', 'Data Type berhasil dibuat');
    }

    public function edit(Type $type)
    {
        return view('type.edit', compact('type'));
    }

    public function update(Request $request, Type $type)
    {
        $request->validate([
            'type' => 'required'
        ]);

        $type->update([
            'type' => $request->type
        ]);

        return redirect('type')->with('success', 'Data type berhasil di edit');
    }

    public function destroy(Type $type)
    {
        $type->delete();

        return redirect()->back()->with('success', 'Data Type berhasil dihapus');
    }
}
