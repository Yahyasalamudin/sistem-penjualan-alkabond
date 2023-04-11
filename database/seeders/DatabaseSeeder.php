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
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'city_branch' => 'Semboro',
            'role' => 'owner'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Dwi Khusnul',
            'username' => 'dwikhusnul',
            'email' => 'dwikhusnul632@gmail.com',
            'phone_number' => '081233247969',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'city_branch' => 'GadingRejo',
            'role' => 'admin'
        ]);

        \App\Models\Sales::factory()->create([
            'sales_name' => 'Rahmat Rendy',
            'username' => 'rahmat',
            'email' => 'rahmat@gmail.com',
            'phone_number' => '081234567890',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'city_branch' => 'Semboro',
        ]);
    }
}
