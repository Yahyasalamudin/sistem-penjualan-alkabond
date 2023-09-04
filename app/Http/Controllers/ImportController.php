<?php

namespace App\Http\Controllers;

use App\Imports\ProductImport;
use App\Imports\SalesImport;
use App\Imports\StoreImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function import_product(Request $request)
    {
        Excel::import(new ProductImport, $request->file('file'));

        return back()->with('success', 'Produk berhasil dimasukkan');
    }

    public function import_store(Request $request)
    {
        Excel::import(new StoreImport, $request->file('file'));

        return back()->with('success', 'Toko berhasil dimasukkan');
    }

    public function import_sales(Request $request)
    {
        Excel::import(new SalesImport, $request->file('file'));

        return back()->with('success', 'Sales berhasil dimasukkan');
    }
}
