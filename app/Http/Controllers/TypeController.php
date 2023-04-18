<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class TypeController extends Controller
{
    public function index()
    {
        $type = Type::get();

        $title = 'Jenis Produk';

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

        return back()->with('success', 'Data Type berhasil dibuat');
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);

        $type = Type::find($id);

        return view('types.edit', compact('type'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required'
        ]);

        Type::find($id)->update([
            'type' => $request->type
        ]);

        return redirect('types')->with('success', 'Data type berhasil di edit');
    }

    public function destroy($id)
    {
        Type::find($id)->delete();

        return back()->with('success', 'Data Type berhasil dihapus');
    }
}
