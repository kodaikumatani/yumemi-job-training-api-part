<?php

namespace Tests\Feature;

use Database\Seeders\ProductSeeder;
use Database\Seeders\SalesSeeder;
use Database\Seeders\StoreSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GetSalesDailyDateTest extends TestCase
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
     * Test if GET method is successful
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson('/api/sales/daily/' . date('Y-m-d'));
        $response->assertStatus(200);
    }

    /**
     * Test if you are returns a certain type.
     *
     * @return void
     */
    public function test_the_application_returns_a_certain_type(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson('/api/sales/daily/'.date('Y-m-d'));
        $response->assertJson(fn (AssertableJson $json) =>
        $json->whereAllType([
            'details.0.store' => 'string',
            'details.0.product' => 'string',
            'details.0.price' => 'integer',
            'details.0.quantity' => 'integer',
            'details.0.total' => 'integer',
        ]));
    }
}
