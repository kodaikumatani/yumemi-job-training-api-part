<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stores = array('愛菜館', 'さんフレッシュ', 'かわはら夢菜館', 'わったいな');
        foreach ($stores as $store) {
            Store::create([
                'name' => $store,
                'user_id' => User::orderBy('id', 'asc')->first()->id,
            ]);
        }
    }
}
