<?php

namespace App\Http\Traits;

use App\Models\Product;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;

trait DashboardTrait
{
    public function topSelling($limit)
    {
        $city = session('filter-city');
        $city_branch = session('filter-city-branch');
        $topSellingProducts = TransactionDetail::select('product_id', DB::raw('SUM(quantity) as totalQuantity'))
            ->groupBy('product_id')
            ->orderByDesc('totalQuantity')
            ->limit($limit);

        if (auth()->user()->role == 'owner' && !empty($city)) {
            $topSellingProducts = $topSellingProducts->whereHas('transaction.sales', function ($query) use ($city) {
                $query->where('city_id', $city);
            });
        }

        if (!empty($city_branch)) {
            $topSellingProducts = $topSellingProducts->whereHas('transaction.sales', function ($query) use ($city_branch) {
                $query->where('city_branch_id', $city_branch);
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
}
