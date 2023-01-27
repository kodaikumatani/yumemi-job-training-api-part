<?php

namespace Tests\Feature;

use Database\Seeders\GetSalesDailyDateStoresTestSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\StoreSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GetSalesDailyDateStoresTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
        $this->seed(StoreSeeder::class);
        $this->seed(ProductSeeder::class);
        $this->seed(GetSalesDailyDateStoresTestSeeder::class);
    }

    /**
     * Return 404 if an invalid value is entered.
     *
     * @return void
     */
    public function test_the_application_returns_404_if_input_an_invalid_value(): void
    {
        $response = $this->get('/api/sales/daily/abc/stores');
        $response->assertStatus(404);
    }

    /**
     * Test if you are returns a certain type.
     *
     * @return void
     */
    public function test_the_application_returns_a_certain_type(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson('/api/sales/daily/' . date('Y-m-d') . '/stores');
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
        $json->whereAllType([
            'details.0.store' => 'string',
            'details.0.total' => 'integer',
        ]));
    }

    /**
     * Test if you are returns a correct store name.
     *
     * @return void
     */
    public function test_the_application_returns_a_correct_store_name(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson('/api/sales/daily/' . date('Y-m-d') . '/stores');
        $response->assertStatus(200);
        $stores = ['愛菜館','さんフレッシュ','かわはら夢菜館','わったいな'];
        foreach ($stores as $i => $value) {
            $response->assertJson(fn (AssertableJson $json) =>
            $json->where('details.'.strval($i).'.store', $value));
        }
    }

    /**
     * Test if you are returns a correct store sales on the day.
     *
     * @return void
     */
    public function test_the_application_returns_a_correct_store_sales_on_the_day(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson('/api/sales/daily/' . date('Y-m-d') . '/stores');
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('details.0.total', 1800)
                ->where('details.1.total', 3600)
                ->where('details.2.total', 5400)
                ->where('details.3.total', 7200));
    }

    /**
     * Test if you are returns a correct store sales the previous day.
     *
     * @return void
     */
    public function test_the_application_returns_a_correct_store_sales_the_previous_day(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson('/api/sales/daily/' . date('Y-m-d', strtotime('-1 day')) . '/stores');
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
        $json->where('details.0.total', 1800*2)
            ->where('details.1.total', 3600*2)
            ->where('details.2.total', 5400*2)
            ->where('details.3.total', 7200*2));
    }
}
