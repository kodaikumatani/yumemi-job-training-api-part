<?php

namespace Database\Seeders;

use App\Models\HourlySales;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        foreach (Store::orderBy('id', 'asc')->pluck('id') as $store_id ) {
            foreach (Product::pluck('id') as $product_id) {
                foreach (range(9, 20) as $idx => $hour ) {
                    HourlySales::create([
                        'date' => '2023-01-03',
                        'hour' => $hour,
                        'user_id' => $user_id,
                        'store_id' => $store_id,
                        'product_id' => $product_id,
                        'quantity' => $idx,
                    ]);
                }
            }
        }
    }
}
