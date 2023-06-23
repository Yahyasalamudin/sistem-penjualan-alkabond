<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Product;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function topSelling($quantity)
    {
        $topSellingProducts = TransactionDetail::select('product_id', DB::raw('SUM(quantity) as totalQuantity'))
            ->groupBy('product_id')
            ->orderByDesc('totalQuantity')
            ->limit($quantity)
            ->get();

        $products = [];
        foreach ($topSellingProducts as $sellingProduct) {
            $product = Product::find($sellingProduct->product_id);
            $product->total_quantity = $sellingProduct->totalQuantity;
            $products[] = $product;
        }

        return $products;
    }

    public function index()
    {
        $transaction = Transaction::count();
        $carbon = Carbon::now();
        $transaction_now = Transaction::whereMonth('created_at', $carbon)->count();
        $remaining_pay = Transaction::sum('remaining_pay');
        $payment = Payment::whereMonth('created_at', $carbon)->sum('total_pay');
        $store = Store::count();
        $product = Product::count();
        $top_selling = $this->topSelling(5);

        return view('dashboard', [
            'title' => 'Dashboard',
            'transaction' => $transaction,
            'transaction_now' => $transaction_now,
            'remaining_pay' => $remaining_pay,
            'payment' => $payment,
            'store' => $store,
            'product' => $product,
            'top_selling' => $top_selling
        ]);
    }
}
