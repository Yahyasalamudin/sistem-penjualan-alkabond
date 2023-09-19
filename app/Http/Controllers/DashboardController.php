<?php

namespace App\Http\Controllers;

use App\Http\Traits\DashboardTrait;
use App\Models\City;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Store;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    use DashboardTrait;

    public function filter_city(Request $request)
    {
        session(['filter-city' => $request->filter_city ?? ""]);
        session(['filter-city-branch' => ""]);

        return back();
    }

    public function filter_city_branch(Request $request)
    {
        session(['filter-city-branch' => $request->filter_city_branch ?? ""]);

        return back();
    }

    public function index()
    {
        $user = auth()->user();
        $city = session('filter-city');
        $city_branch = session('filter-city-branch');

        $transaction = Transaction::where('deleted_at', null)
            ->filterCity($user, $city, $city_branch)->count();

        $transaction_now = Transaction::where('deleted_at', null)
            ->whereMonth('created_at', now()->month)
            ->filterCity($user, $city, $city_branch)->count();

        $remaining_pay = Transaction::where('deleted_at', null)->filterCity($user, $city, $city_branch)->sum('remaining_pay');

        $payment = Payment::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->filterCity($user, $city, $city_branch)->sum('total_pay');

        $store = Store::filterCity($user, $city, $city_branch)->count();

        $product = Product::count();

        $top_selling = $this->topSelling(5);

        $transaction_chart = Transaction::selectRaw('MONTH(created_at) as month, SUM(grand_total) as pendapatan')
            ->where('deleted_at', null)
            ->whereYear('created_at', now()->year)
            ->filterCity($user, $city, $city_branch)
            ->groupBy('month')
            ->get();

        $pendapatan = $transaction_chart->pluck('pendapatan')->map(function ($value) {
            return intval($value);
        });

        $months = $transaction_chart->pluck('month')->map(function ($value) {
            return Carbon::create()->month($value)->locale(app()->getLocale())->isoFormat('MMMM');
        });

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
