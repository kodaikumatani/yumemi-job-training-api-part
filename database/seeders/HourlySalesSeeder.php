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
        $period = CarbonPeriod::start(date('Y-m-d', strtotime('-30 day')))
            ->untilNow()->toArray();
        foreach ($period as $date) {
            $qtyInfo = $this->initializeArray();
            foreach (range(9, 20) as $hour) {
                foreach (Store::pluck('id') as $store_id) {
                    foreach (Product::pluck('id') as $product_id) {
                        $qtyInfo[$store_id-1][$product_id-1] += rand(0,5);
                        HourlySales::create([
                            'date' => $date->format('Y-m-d'),
                            'hour' => $hour,
                            'user_id' => $user_id,
                            'store_id' => $store_id,
                            'product_id' => $product_id,
                            'quantity' => $qtyInfo[$store_id-1][$product_id-1],
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Store Quantity info.
     *
     * @return array
     */
    protected function initializeArray(): array
    {
        $data = array();
        foreach (Store::pluck('id') as $store_id) {
            $data[] = array_fill(0, Product::count(), 0);
        }
        return $data;
    }
}
