<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Sales;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = -30; $i < 1; $i++) {
            foreach (Store::pluck('id') as $store_id) {
                foreach (Product::pluck('id') as $product_id) {
                    Sales::create([
                        'date' => date('Y-m-d', strtotime((string)$i . ' day')),
                        'user_id' => User::orderBy('id', 'asc')->first()->value('id'),
                        'store_id' => $store_id,
                        'product_id' => $product_id,
                        'quantity' => rand(1, 30),
                    ]);
                }
            }
        }
    }
}
