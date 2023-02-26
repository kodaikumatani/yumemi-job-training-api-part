<?php

namespace Tests\Feature;

use Database\Seeders\GetSalesDailyDateProductsTestSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\StoreSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GetSalesDailyDateProductsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
        $this->seed(StoreSeeder::class);
        $this->seed(ProductSeeder::class);
        $this->seed(GetSalesDailyDateProductsTestSeeder::class);
    }

    /**
     * Return 404 if an invalid value is entered.
     *
     * @return void
     */
    public function test_the_application_returns_404_if_input_an_invalid_value(): void
    {
        $response = $this->get('/api/sales/daily/abc/products');
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
        $response = $this->getJson('/api/sales/daily/2023-01-02/products');
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
        $json->whereAllType([
            'details.0.name' => 'string',
            'details.0.value' => 'integer',
        ]));
    }

    /**
     * Test if you are returns a correct product name.
     *
     * @return void
     */
    public function test_the_application_returns_a_correct_product_name(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson('/api/sales/daily/2023-01-02/products');
        $response->assertStatus(200);
        $products = ['もち','おはぎ','おこわ','みそ'];
        foreach ($products as $i => $value) {
            $response->assertJson(fn(AssertableJson $json) =>
            $json->where('details.' . strval($i) . '.name', $value));
        }
    }

    /**
     * Test if you are returns a correct product sales.
     *
     * @return void
     */
    public function test_the_application_returns_a_correct_product_sales(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson('/api/sales/daily/2023-01-02/products');
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
        $json->where('details.0.value', 7500)
            ->where('details.1.value', 2500)
            ->where('details.2.value', 3000)
            ->where('details.3.value', 5000));
    }
}
