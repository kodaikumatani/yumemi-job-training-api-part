<?php

namespace Tests\Feature;

use Database\Seeders\ProductSeeder;
use Database\Seeders\SalesSeeder;
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
        $this->seed(SalesSeeder::class);
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
            $json->has('summary.0', fn ($json) =>
                $json->whereAllType([
                    'date' => 'string',
                    'amount' => 'integer'
                ])));
    }
}
