<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $city = [
            ['city' => 'Malang'],
            ['city' => 'Surabaya'],
            ['city' => 'Bekasi'],
            ['city' => 'Jember']
        ];

        $city_branch = [
            [
                'city_id' => 1,
                'branch' => 'Kepanjen'
            ],
            [
                'city_id' => 2,
                'branch' => 'Rungkut'
            ],
            [
                'city_id' => 3,
                'branch' => 'Bekasi Selatan'
            ],
            [
                'city_id' => 4,
                'branch' => 'Semboro'
            ]
        ];

        \App\Models\City::insert($city);
        \App\Models\CityBranch::insert($city_branch);
    }
}
