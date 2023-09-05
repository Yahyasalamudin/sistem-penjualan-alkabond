<?php

namespace App\Imports;

use App\Models\City;
use App\Models\CityBranch;
use App\Models\Sales;
use App\Models\Store;
use Maatwebsite\Excel\Concerns\ToModel;

class StoreImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $city = City::where('city', $row[3])->first();
        $city_branch = CityBranch::where('branch', $row[4])->first();
        $sales = Sales::where('sales_name', $row[5])->first();

        if (!empty($city) && !empty($city_branch) && !empty($sales)) {
            return new Store([
                'store_name' => $row[0],
                'address' => $row[1],
                'store_number' => $row[2],
                'city_id' => $city->id,
                'city_branch_id' => $city_branch->id,
                'sales_id' => $sales->id,
            ]);
        }
    }
}
