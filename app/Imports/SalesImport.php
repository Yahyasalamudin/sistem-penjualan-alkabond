<?php

namespace App\Imports;

use App\Models\City;
use App\Models\CityBranch;
use App\Models\Sales;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class SalesImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $city = City::where('city', $row[5])->first();
        $city_branch = CityBranch::where('branch', $row[6])->first();

        if (!empty($city) && !empty($city_branch)) {
            return new Sales([
                'sales_name' => $row[0],
                'username' => $row[1],
                'email' => $row[2],
                'phone_number' => $row[3],
                'password' => Hash::make($row[4]),
                'city_id' => $city->id,
                'city_branch_id' => $city_branch->id,
                'active' => 1,
            ]);
        }
    }
}
