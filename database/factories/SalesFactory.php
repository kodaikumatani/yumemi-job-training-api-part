<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Store;
use App\Models\Product;
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
        $user_id = User::orderBy('id', 'asc')->first()->value('id');
        return [
            'date' => fake()->dateTimeBetween($startDate = '-30 days', $endDate = 'now')->format("Y-m-d"),
            'user_id' => $user_id,
            'store_id' => Store::where('user_id', $user_id)->inRandomOrder()->value("id"),
            'product_id' => Product::where('user_id', $user_id)->inRandomOrder()->value("id"),
            'price' => fake()->randomElement(['250','300','500']),
            'quantity' => fake()->numberBetween(0,10),
        ];
    }
}
