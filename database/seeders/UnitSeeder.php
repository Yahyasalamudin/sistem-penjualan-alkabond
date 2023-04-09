<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unit = [
            [
                'unit_name' => 'Sak',
                'amount' => '50 Kg'
            ],

            [
                'unit_name' => 'Sak',
                'amount' => '40 Kg'
            ],

            [
                'unit_name' => 'Sak',
                'amount' => '30 Kg'
            ],

            [
                'unit_name' => 'Bungkus',
                'amount' => '5 Kg'
            ],

            [
                'unit_name' => 'Bungkus',
                'amount' => '1 Kg'
            ],

            [
                'unit_name' => 'Bungkus',
                'amount' => '500 gr'
            ],

            [
                'unit_name' => 'Sachet',
                'amount' => '50 gr'
            ],
        ];

        Unit::insert($unit);
    }
}
