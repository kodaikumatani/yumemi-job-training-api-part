<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_id = User::orderBy('id', 'asc')->first()->value('id');
        $stores = array('愛菜館', 'さんフレッシュ');
        foreach ($stores as $store) {
            Store::create([
                'name' => $store,
                'user_id' => $user_id,
            ]);
        }
    }
}
