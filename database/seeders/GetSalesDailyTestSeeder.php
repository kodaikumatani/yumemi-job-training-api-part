<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Sales;
use App\Models\Store;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GetSalesDailyTestSeeder extends Seeder
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
        $period = CarbonPeriod::start(date('Y-m-d', strtotime('-30 day')))->untilNow()->toArray();
        foreach ($period as $date) {
            $diff_day = $date->diff(date('Y-m-d'))->days;
            foreach (Product::pluck('id') as $product_id) {
                Sales::create([
                    'date' => $date->format('Y-m-d'),
                    'hour' => 10,
                    'user_id' => $user_id,
                    'store_id' => $store_id,
                    'product_id' => $product_id,
                    'quantity' => $diff_day + 1,
                ]);
            }
        }
    }
}
