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
        $city = session('filterKota');
        $topSellingProducts = TransactionDetail::select('product_id', DB::raw('SUM(quantity) as totalQuantity'))
            ->groupBy('product_id')
            ->orderByDesc('totalQuantity')
            ->limit($quantity);

        if (auth()->user()->role == 'owner') {
            // $topSellingProducts = $topSellingProducts->where('city', session('filterKota'));
            $topSellingProducts = $topSellingProducts->whereHas('transaction.sales', function ($query) use ($city) {
                $query->where('city', $city);
            });
        }

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
        $city = session('filterKota');

        $transaction = Transaction::where('deleted_at', null)
            ->when($user->role == 'owner', function ($query) use ($city) {
                $query->whereHas('sales', function ($query) use ($city) {
                    $query->where('city', $city);
                });
            })
            ->when($user->role == 'admin', function ($query) use ($user) {
                $query->whereHas('sales', function ($query) use ($user) {
                    $query->where('city', $user->city);
                });
            })
            ->count();

        $transaction_now = Transaction::where('deleted_at', null)
            ->whereMonth('created_at', now()->month)
            ->when($user->role == 'owner', function ($query) use ($city) {
                $query->whereHas('sales', function ($query) use ($city) {
                    $query->where('city', $city);
                });
            })
            ->when($user->role == 'admin', function ($query) use ($user) {
                $query->whereHas('sales', function ($query) use ($user) {
                    $query->where('city', $user->city);
                });
            })
            ->count();

        $remaining_pay = Transaction::where('deleted_at', null)
            ->when($user->role == 'owner', function ($query) use ($city) {
                $query->whereHas('sales', function ($query) use ($city) {
                    $query->where('city', $city);
                });
            })
            ->when($user->role == 'admin', function ($query) use ($user) {
                $query->whereHas('sales', function ($query) use ($user) {
                    $query->where('city', $user->city);
                });
            })
            ->sum('remaining_pay');

        $payment = Payment::whereMonth('created_at', now()->month)
            ->when($user->role == 'owner', function ($query) use ($city) {
                $query->whereHas('transactions.sales', function ($query) use ($city) {
                    $query->where('city', $city);
                });
            })
            ->when($user->role == 'admin', function ($query) use ($user) {
                $query->whereHas('transactions.sales', function ($query) use ($user) {
                    $query->where('city', $user->city);
                });
            })
            ->sum('total_pay');

        $store = Store::when($user->role == 'owner', function ($query) use ($city) {
            $query->where('city_branch', $city);
        })
            ->when($user->role == 'admin', function ($query) use ($user) {
                $query->where('city_branch', $user->city);
            })
            ->count();

        $product = Product::count();

        $top_selling = $this->topSelling(5);

        $transaction_chart = Transaction::selectRaw('MONTH(created_at) as month, SUM(grand_total) as pendapatan')
            ->where('deleted_at', null)
            ->whereYear('created_at', now()->year)
            ->when($user->role == 'owner', function ($query) use ($city) {
                $query->whereHas('sales', function ($query) use ($city) {
                    $query->where('city', $city);
                });
            })
            ->when($user->role == 'admin', function ($query) use ($user) {
                $query->whereHas('sales', function ($query) use ($user) {
                    $query->where('city', $user->city);
                });
            })
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
