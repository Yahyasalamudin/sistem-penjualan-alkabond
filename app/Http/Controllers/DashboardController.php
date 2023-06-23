<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Product;
use App\Models\Store;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaction = Transaction::count();
        $carbon = Carbon::now();
        $transaction_now = Transaction::whereMonth('created_at', $carbon)->count();
        $grand_total_month = Transaction::whereMonth('created_at', $carbon)->sum('grand_total');
        $payment = Payment::whereMonth('created_at', $carbon)->sum('total_pay');
        $store = Store::count();
        $product = Product::count();

        return view('dashboard', [
            'title' => 'Dashboard',
            'transaction' => $transaction,
            'transaction_now' => $transaction_now,
            'grand_total_month' => $grand_total_month,
            'payment' => $payment,
            'store' => $store,
            'product' => $product,
        ]);
    }
}
