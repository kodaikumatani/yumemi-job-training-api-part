<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_id = User::orderBy('id', 'asc')->first()->value('id');
        $products[] = array('name'=>'おこわ', 'price'=>array(300));
        $products[] = array('name'=>'みそ', 'price'=>array(500));
        foreach ($products as $product) {
            foreach ($product['price'] as $price) {
                Product::create([
                    'user_id' => $user_id,
                    'name' => $product['name'],
                    'price' => $price,
                ]);
            }
        }
    }
}
