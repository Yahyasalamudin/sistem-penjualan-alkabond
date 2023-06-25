<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            ->limit($quantity);

        // if (auth()->user()->role == 'owner') {
        //     $topSellingProducts = $topSellingProducts->where('city', session('filterKota'));
        // }

        $topSellingProducts = $topSellingProducts->get();

        $products = [];
        foreach ($topSellingProducts as $sellingProduct) {
            $product = Product::find($sellingProduct->product_id);
            $product->total_quantity = $sellingProduct->totalQuantity;
            $products[] = $product;
        }

        return $products;
    }

    public function filterKota(Request $request)
    {
        session(['filterKota' => $request->filterKota]);

        return back();
    }

    public function index()
    {
        $user = auth()->user();

        $transaction = Transaction::count();
        $carbon = Carbon::now();
        $transaction_now = Transaction::whereMonth('created_at', $carbon)->count();
        $remaining_pay = Transaction::sum('remaining_pay');
        $payment = Payment::whereMonth('created_at', $carbon)->sum('total_pay');
        $store = Store::count();
        $product = Product::count();
        $top_selling = $this->topSelling(5);
        $transaction_chart = Transaction::select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(grand_total) as pendapatan'))
            ->where('deleted_at', null)
            ->whereYear('created_at', $carbon->year)
            ->groupBy('month');

        // if ($user->role == 'owner') {
        //     $transaction = $transaction->where('city', session('filterKota'));
        //     $transaction_now = $transaction_now->where('city', session('filterKota'));
        //     $remaining_pay = $remaining_pay->where('city', session('filterKota'));
        //     $payment = $payment->where('city', session('filterKota'));
        //     $store = $store->where('city', session('filterKota'));
        //     $product = $product->where('city', session('filterKota'));
        //     $transaction_chart = $transaction_chart->where('city', session('filterKota'));
        // }

        // if (auth()->user()->role == 'admin') {
        //     $transaction = $transaction->where('city', $user->city);
        //     $transaction_now = $transaction_now->where('city', $user->city);
        //     $remaining_pay = $remaining_pay->where('city', $user->city);
        //     $payment = $payment->where('city', $user->city);
        //     $store = $store->where('city', $user->city);
        //     $product = $product->where('city', $user->city);
        //     $transaction_chart = $transaction_chart->where('city', $user->city);
        // }

        $transaction_chart = $transaction_chart->get();

        // dd($transaction_chart);

        $pendapatan = [];
        $months = [];
        foreach ($transaction_chart as $row) {
            $pendapatan[] = intval($row->pendapatan);
            $monthName = Carbon::create()->month($row->month)->locale(app()->getLocale())->isoFormat('MMMM');
            $months[] = $monthName;
        }

        return view('dashboard', [
            'title' => 'Dashboard',
            'transaction' => $transaction,
            'transaction_now' => $transaction_now,
            'remaining_pay' => $remaining_pay,
            'payment' => $payment,
            'store' => $store,
            'product' => $product,
            'top_selling' => $top_selling,
            'pendapatan' => $pendapatan,
            'months' => $months,
        ]);
    }
}
