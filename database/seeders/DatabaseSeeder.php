<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TypeSeeder::class);

        \App\Models\User::factory(10)->create();
        \App\Models\City::factory(10)->create();
        \App\Models\Sales::factory(10)->create();


        \App\Models\User::factory()->create([
            'name' => 'Yahya Salamudin',
            'username' => 'yahyasalamudin',
            'email' => 'yahyasalamudin@gmail.com',
            'phone_number' => '081233247969',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            // password
            'city' => 'Semboro',
            'role' => 'owner'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Dwi Khusnul',
            'username' => 'dwikhusnul',
            'email' => 'dwikhusnul632@gmail.com',
            'phone_number' => '081233247969',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            // password
            'city' => 'GadingRejo',
            'role' => 'admin'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Jenira Sekar',
            'username' => 'sekar',
            'email' => 'sekar@gmail.com',
            'phone_number' => '081233247969',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            // password
            'city' => 'Semboro',
            'role' => 'admin'
        ]);

        \App\Models\Sales::factory()->create([
            'sales_name' => 'Rahmat Rendy',
            'username' => 'rahmat',
            'email' => 'rahmat@gmail.com',
            'phone_number' => '081234567890',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            // password
            'city' => 'Semboro',
        ]);

        \App\Models\Store::factory()->create([
            'store_name' => 'Toko Jaya Abadi',
            'address' => 'Semboro',
            'store_number' => '082123123123',
            'city_branch' => 'Semboro',
            'sales_id' => '1',
        ]);

        \App\Models\Product::factory()->create([
            'product_code' => 'PBR202304100001',
            'product_name' => 'Perekat Bata Ringan',
            'product_brand' => 'Alkabon / MORBON',
            'unit_weight' => 'sak @ 30kg',
        ]);

        \App\Models\Product::factory()->create([
            'product_code' => 'AC2023100002',
            'product_name' => 'Acian Putih',
            'product_brand' => 'Alkabon 100 - MUI',
            'unit_weight' => 'sak @ 40kg',
        ]);
    }
}
