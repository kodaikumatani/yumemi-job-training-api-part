<?php

namespace Tests\Feature;

use Database\Seeders\ProductSeeder;
use Database\Seeders\StoreSeeder;
use Database\Seeders\tests\GetSalesDailyDateStoresTestSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
     * TableMenu if you are returns a certain type.
     *
     * @return void
     */
    public function test_the_application_returns_a_certain_type(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson('/api/sales/daily/2023-01-01/stores');
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
        $json->whereAllType([
            'details.0.name' => 'string',
            'details.0.value' => 'integer',
        ]));
    }

    /**
     * TableMenu if you are returns a correct store name.
     *
     * @return void
     */
    public function test_the_application_returns_a_correct_store_name(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson('/api/sales/daily/2023-01-01/stores');
        $response->assertStatus(200);
        $stores = ['愛菜館','さんフレッシュ','かわはら夢菜館','わったいな'];
        foreach ($stores as $i => $value) {
            $response->assertJson(fn (AssertableJson $json) =>
            $json->where('details.'.strval($i).'.name', $value));
        }
    }

    /**
     * TableMenu if you are returns a correct store sales.
     *
     * @return void
     */
    public function test_the_application_returns_a_correct_store_sales(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson('/api/sales/daily/2023-01-01/stores');
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('details.0.value', 1800)
                ->where('details.1.value', 3600)
                ->where('details.2.value', 5400)
                ->where('details.3.value', 7200));
    }
}
