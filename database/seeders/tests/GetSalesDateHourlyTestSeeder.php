<?php

namespace Database\Seeders\tests;

use App\Models\Product;
use App\Models\Sales;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;

class GetSalesDateHourlyTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_id = User::orderBy('id', 'asc')->first()->value('id');
        $store_id = Store::orderBy('id', 'asc')->first()->value('id');
        foreach (Product::pluck('id') as $product_id) {
            foreach (range(10, 20) as $idx => $hour) {
                Sales::create([
                    'date' => '2023-01-03',
                    'hour' => $hour,
                    'user_id' => $user_id,
                    'store_id' => $store_id,
                    'product_id' => $product_id,
                    'quantity' => $idx,
                    'store_total' => $idx,
                ]);
            }
        }
    }
}
