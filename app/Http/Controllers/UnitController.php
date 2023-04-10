<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $unit = Unit::get();

        $title = 'Unit';

        return view('units.index', compact('unit', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_name' => 'required',
            'amount' => 'required'
        ]);

        Unit::create([
            'unit_name' => $request->unit_name,
            'amount' => $request->amount,
        ]);

        return redirect()->back()->with('success', 'Data Unit Berhasil ditambahkan');
    }

    public function edit(Unit $unit)
    {
        return view('units.edit', compact('unit'));
    }

    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'unit_name' => 'required',
            'amount' => 'required'
        ]);

        $unit->update([
            'unit_name' => $request->unit_name,
            'amount' => $request->amount,
        ]);

        return redirect('units')->with('success', 'Data Unit berhasil diubah');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();

        return redirect()->back()->with('success', 'Data Unit berhasil dihapus');
    }
}
