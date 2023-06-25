<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sales>
 */
class SalesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $city = ['Jember', 'Surabaya', 'Malang', 'Bekasi'];

        return [
            'sales_name' => $this->faker->name(),
            'username' => $this->faker->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_number' => '08' . $this->faker->numberBetween(9, 12) . $this->faker->randomNumber(9),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'city' => $this->faker->randomElement($city),
        ];
    }
}
