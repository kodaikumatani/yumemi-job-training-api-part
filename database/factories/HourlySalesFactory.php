<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HourlySales>
 */
class HourlySalesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'date' => fake()->dateTimeBetween($startDate = '-30 days', $endDate = 'now')->format("Y-m-d"),
            'hour' => fake()->numberBetween(9,21),
            'user_id' => User::orderBy('id', 'asc')->first()->id,
            'store_id' => fake()->numberBetween(1,4),
            'product_id' => fake()->numberBetween(1,4),
            'price' => fake()->randomElement(['250','300','500']),
            'quantity' => fake()->numberBetween(0,10),
        ];
    }
}
