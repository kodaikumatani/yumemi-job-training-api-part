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
     * A basic feature test example.
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
                'summary.0.amount' => 'integer'
                ]));
    }

    /**
     * Test if you are returns a correct value.
     *
     * @return void
     */
    public function test_the_application_returns_a_correct_value(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson('/api/sales/daily/');
        $response->assertStatus(200);
        for ($i = 0; $i < 31; $i++) {
            $response->assertJson(fn(AssertableJson $json) =>
            $json->where('summary.' . $i . '.amount', 55800 - ($i*1800)));
        }
    }
}
