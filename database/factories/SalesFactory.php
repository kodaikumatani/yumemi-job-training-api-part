<?php

namespace Database\Factories;

use App\Models\Sales;
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
    public function definition(): array
    {
        while (True) {
            $date = fake()->dateTimeBetween($startDate = '-30 days', $endDate = 'now')->format("Y-m-d");
            $user_id = User::orderBy('id', 'asc')->first()->value('id');
            $store_id = Store::where('user_id', $user_id)->inRandomOrder()->value("id");
            $product_id = Product::where('user_id', $user_id)->inRandomOrder()->value("id");
            $unregistered = Sales::where([
                ['date', $date],
                ['user_id', $user_id],
                ['store_id', $store_id],
                ['product_id', $product_id],
            ])->doesntExist();

            if ($unregistered) break;
        }
        return [
            'date' => $date,
            'user_id' => $user_id,
            'store_id' => $store_id,
            'product_id' => $product_id,
            'quantity' => fake()->numberBetween(0, 10),
        ];
    }
}
