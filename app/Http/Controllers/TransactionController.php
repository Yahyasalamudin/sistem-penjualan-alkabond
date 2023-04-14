<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Store;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transaction = Transaction::latest()->get();
        return view('transaction.index', compact('transaction'));
    }

    public function create()
    {
        $store = Store::latest()->get();

        return view('transaction.create', compact('store'));
    }
}
