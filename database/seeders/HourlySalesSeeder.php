<?php

namespace Database\Seeders;

use App\Models\HourlySales;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HourlySalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $user_id = User::orderBy('id', 'asc')->first()->value('id');
        $period = CarbonPeriod::start(date('Y-m-d', strtotime('-30 day')))->untilNow()->toArray();
        foreach ($period as $date) {
            foreach (Store::pluck('id') as $store_id) {
                foreach (Product::pluck('id') as $product_id) {
                    $qty = 0;
                    foreach (range(9, 20) as $hour) {
                        $qty += rand(0,5);
                        HourlySales::create([
                            'dateTime' => $date->format('Y-m-d ') . $hour . ':00:00',
                            'hour' => $hour,
                            'user_id' => $user_id,
                            'store_id' => $store_id,
                            'product_id' => $product_id,
                            'quantity' => $qty,
                        ]);
                    }
                }
            }
        }
    }
}
