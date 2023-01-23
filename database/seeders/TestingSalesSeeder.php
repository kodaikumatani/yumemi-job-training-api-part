<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Sales;
use App\Models\Store;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestingSalesSeeder extends Seeder
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
            foreach (Store::orderBy('id', 'asc')->pluck('id') as $idx => $store_id ) {
                foreach (Product::pluck('id') as $product_id) {
                    Sales::create([
                        'date' => $date->format('Y-m-d'),
                        'user_id' => $user_id,
                        'store_id' => $store_id,
                        'product_id' => $product_id,
                        'quantity' => $idx+1,
                    ]);
                }
            }
        }
    }
}
