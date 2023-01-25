<?php

namespace Tests\Feature;

use Database\Seeders\GetSalesDailyDateTestSeeder;
use Database\Seeders\ProductSeeder;
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
        $this->seed(GetSalesDailyDateTestSeeder::class);
    }

    /**
     * Return 404 if an invalid value is entered.
     *
     * @return void
     */
    public function test_the_application_returns_404_if_input_an_invalid_value(): void
    {
        $response = $this->get('/api/sales/daily/abc');
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
        $response = $this->getJson('/api/sales/daily/' . date('Y-m-d'));
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
        $json->whereAllType([
            'details.0.store' => 'string',
            'details.0.product' => 'string',
            'details.0.price' => 'integer',
            'details.0.quantity' => 'integer',
            'details.0.total' => 'integer',
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
        $response = $this->getJson('/api/sales/daily/' . date('Y-m-d'));
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) => $json
            # 1st record
            ->where('details.0.store','愛菜館')
            ->where('details.0.product', 'おこわ')
            ->where('details.0.price', 300)
            ->where('details.0.quantity', 1)
            ->where('details.0.total', 300)
            # 2nd record
            ->where('details.1.store','愛菜館')
            ->where('details.1.product', 'みそ')
            ->where('details.1.price', 500)
            ->where('details.1.quantity', 1)
            ->where('details.1.total', 500)
            # 3rd record
            ->where('details.2.store','さんフレッシュ')
            ->where('details.2.product', 'おこわ')
            ->where('details.2.price', 300)
            ->where('details.2.quantity', 2)
            ->where('details.2.total', 600)
            # 4th record
            ->where('details.3.store','さんフレッシュ')
            ->where('details.3.product', 'みそ')
            ->where('details.3.price', 500)
            ->where('details.3.quantity', 2)
            ->where('details.3.total', 1000));
    }
}
