<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = array('おはぎ','もち','おこわ','みそ');
        foreach ($products as $product) {
            Product::create([
                'name' => $product,
                'user_id' => 1,
            ]);
        }
    }
}
