<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = DB::table('transactions')
            ->join('stores', 'transactions.store_id', 'stores.id')
            ->join('sales', 'transactions.sales_id', 'sales.id')
            ->select('transactions.*', 'stores.store_name', 'stores.address', 'stores.store_number', 'stores.city_branch')
            ->orderByDesc('transactions.created_at')
            ->get();

        if (auth()->user()->role == 'admin') {
            $transactions = DB::table('transactions')
                ->where('stores.city_branch', auth()->user()->city)
                ->join('stores', 'transactions.store_id', 'stores.id')
                ->select('transactions.*', 'stores.store_name', 'stores.address', 'stores.store_number', 'stores.city_branch')
                ->orderByDesc('transactions.created_at')
                ->get();
        }

        return view('transactions.index', compact('transactions'));
    }

    public function show($invoice_code)
    {
        $transaction = DB::table('transactions')
            ->where('invoice_code', $invoice_code)
            ->join('stores', 'transactions.store_id', 'stores.id')
            ->join('sales', 'transactions.sales_id', 'sales.id')
            ->select('transactions.*', 'stores.store_name', 'stores.address', 'stores.store_number', 'stores.city_branch', 'sales.sales_name', 'sales.username', 'sales.phone_number', 'sales.city')
            ->orderByDesc('transactions.created_at')
            ->first();

        $transactionDetail = DB::table('transaction_details')
            ->where('invoice_code', $transaction->invoice_code)
            ->join('products', 'transaction_details.product_id', 'products.id')
            ->select('transaction_details.*', 'products.product_code', 'products.product_code', 'products.product_name', 'products.product_brand', 'products.unit_weight')
            ->get();

        return view('transactions.detail', compact('transaction', 'transactionDetail'));
    }
}
