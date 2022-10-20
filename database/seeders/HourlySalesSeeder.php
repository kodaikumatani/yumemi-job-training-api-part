<?php

namespace Database\Seeders;

use App\Models\HourlySales;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HourlySalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = -30; $i < 1; $i++) {
            $qtyInfo = $this->initializeArray();
            foreach (range(9, 20) as $hour) {
                foreach (Store::pluck('id') as $store_id) {
                    foreach (Product::pluck('id') as $product_id) {
                        $qtyInfo[$store_id-1][$product_id-1] += rand(0,5);
                        HourlySales::create([
                            'date' => date('Y-m-d', strtotime((string)$i . ' day')),
                            'hour' => $hour,
                            'user_id' => User::orderBy('id', 'asc')->first()->value('id'),
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
