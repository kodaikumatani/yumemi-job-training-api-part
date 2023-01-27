<?php

namespace Tests\Feature;

use Database\Seeders\GetSalesDateHourlyTestSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\StoreSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GetSalesDateHourlyTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
        $this->seed(StoreSeeder::class);
        $this->seed(ProductSeeder::class);
        $this->seed(GetSalesDateHourlyTestSeeder::class);
    }

    /**
     * Return 404 if an invalid value is entered.
     *
     * @return void
     */
    public function test_the_application_returns_404_if_input_an_invalid_value(): void
    {
        $response = $this->get('/api/sales/abc/hours');
        $response->assertStatus(404);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response_and_a_certain_type(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson('/api/sales/2023-01-03/hourly');
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
        $json->whereAllType([
            'details.0.hour' => 'integer',
            'details.0.amount' => 'integer'
        ]));
    }

    /**
     * Test if you are returns a correct hourly sales.
     *
     * @return void
     */
    public function test_the_application_returns_a_correct_hourly_sales(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson('/api/sales/2023-01-03/hourly');
        $response->assertStatus(200);
        foreach (range(9, 20) as $i => $hour ) {
            $response->assertJson(fn(AssertableJson $json) =>
            $json->where('details.' . $i . '.amount', 7200*$i));
        }
    }
}
