<?php

namespace Database\Seeders;

use App\Models\Sales;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $user_id = User::orderBy('id', 'asc')->first()->value('id');
        $period = CarbonPeriod::start(date('Y-m-d', strtotime('-14 day')))->untilNow()->toArray();
        foreach ($period as $date) {
            foreach (Store::pluck('id') as $store_id) {
                foreach (Product::pluck('id') as $product_id) {
                    foreach (range(10, 20) as $hour) {
                        Sales::create([
                            'date' => $date->format('Y-m-d'),
                            'hour' => $hour,
                            'user_id' => $user_id,
                            'store_id' => $store_id,
                            'product_id' => $product_id,
                            'quantity' => rand(0,5),
                        ]);
                    }
                }
            }
        }
    }
}
