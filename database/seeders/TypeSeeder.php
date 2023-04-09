<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = [
            ['type' => 'Perekat Bata Ringan'],
            ['type' => 'Plaster'],
            ['type' => 'Acian Putih'],
            ['type' => 'Acian Putih Kecil'],
            ['type' => 'Acian Abu-Abu'],
            ['type' => 'Mortar Multi FUngsi'],
            ['type' => 'Peningkat Daya Rekat Semen'],
            ['type' => 'Gypsum Additive'],
            ['type' => 'Additive Anti Air'],
        ];

        Type::insert($type);
    }
}
