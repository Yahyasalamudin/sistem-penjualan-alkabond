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
        $transaction = Transaction::count();
        $thisMonthTransaction = Transaction::
            where('date')
            ->count();


        return response()->json([
            'data' => [
                'transaction' => $transaction,
            ],
            'message' => 'Fetch dashboard',
            'status_code' => 200
        ]);
    }
}