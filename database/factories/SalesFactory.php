<?php

namespace Database\Factories;

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
        return [
            'date' => fake()->dateTimeBetween($startDate = '-30 days', $endDate = 'now')->format("Y-m-d"),
            'user_id' => 1,
            'store_id' => fake()->numberBetween(1,4),
            'product_id' => fake()->numberBetween(1,4),
            'price' => fake()->randomElement(['250','300','500']),
            'quantity' => fake()->numberBetween(0,10),
        ];
    }
}
