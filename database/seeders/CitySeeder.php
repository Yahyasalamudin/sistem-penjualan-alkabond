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

        \App\Models\City::insert($city);
    }
}
