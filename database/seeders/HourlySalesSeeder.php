<?php

namespace Database\Seeders;

use App\Models\HourlySales;
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
        HourlySales::factory()->count(5000)->save();
    }
}
