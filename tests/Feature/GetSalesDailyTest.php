<?php

namespace Tests\Feature;

use Database\Seeders\GetSalesDailyTestSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\StoreSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\UserSeeder;

class GetSalesDailyTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
        $this->seed(StoreSeeder::class);
        $this->seed(ProductSeeder::class);
        $this->seed(GetSalesDailyTestSeeder::class);
    }

    /**
     * Test if you are returns a certain type.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response_and_a_certain_type(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson('/api/sales/daily');
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->whereAllType([
                'summary.0.date' => 'string',
                'summary.0.value' => 'integer'
                ]));
    }

    /**
     * Test if you are returns a correct value.
     * Sales increase by 1800 per day.
     *
     * @return void
     */
    public function test_the_application_returns_a_correct_value(): void
    {
        $amount_all_items_sold_one = 1800;
        $this->withoutExceptionHandling();
        $response = $this->getJson('/api/sales/daily/');
        $response->assertStatus(200);
        foreach (range(31, 1) as $i => $days_ago ) {
            $response->assertJson(fn(AssertableJson $json) =>
            $json->where('summary.' . $i . '.value', $amount_all_items_sold_one*$days_ago));
        }
    }
}
