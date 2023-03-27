<?php

namespace Database\Seeders\tests;

use App\Models\Product;
use App\Models\Sales;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;

class GetSalesDailyDateTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_id = User::orderBy('id', 'asc')->first()->value('id');
        foreach (Store::orderBy('id', 'asc')->pluck('id') as $idx => $store_id ) {
            foreach (Product::orderBy('id', 'desc')->pluck('id') as $product_id) {
                Sales::create([
                    'date' => date('Y-m-d'),
                    'hour' => $idx,
                    'user_id' => $user_id,
                    'store_id' => $store_id,
                    'product_id' => $product_id,
                    'quantity' => $idx + 1,
                    'store_total' => $idx + 1,
                ]);
            }
        }
    }
}
