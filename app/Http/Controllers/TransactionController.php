<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Store;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::latest()->get();

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $store = Store::latest()->get();

        return view('transaction.create', compact('store'));
    }
}
