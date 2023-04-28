<?php

namespace App\Http\Controllers\api;

use App\Models\Transaction;
use App\Models\Store;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        $transaction = Transaction::count();
        $thisMonthTransaction = Transaction::
            whereMonth('created_at', $now->month)
            ->count();

        return response()->json([
            'data' => [
                'transaction' => $transaction,
                'this_month_transaction' => $thisMonthTransaction,
            ],
            'message' => 'Fetch dashboard',
            'status_code' => 200
        ]);
    }
}