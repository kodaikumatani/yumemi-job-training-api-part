<?php

namespace Tests\Feature;

use Database\Seeders\ProductSeeder;
use Database\Seeders\StoreSeeder;
use Database\Seeders\TestingSalesSeeder;
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
        $this->seed(TestingSalesSeeder::class);
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
     * Test if you are returns a correct store name.
     *
     * @return void
     */
    public function test_the_application_returns_a_correct_value(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson('/api/sales/daily/' . date('Y-m-d'));
        $response->assertStatus(200);

        $stores = ['愛菜館','さんフレッシュ','かわはら夢菜館','わったいな'];
        $products[] = array('name'=>'もち', 'price'=>array(250, 500));
        $products[] = array('name'=>'おはぎ', 'price'=>array(250));
        $products[] = array('name'=>'おこわ', 'price'=>array(300));
        $products[] = array('name'=>'みそ', 'price'=>array(500));
        $i = 0;
        foreach ($stores as $idx => $store) {
            foreach ($products as $product) {
                foreach ($product['price'] as $price) {
                    $response->assertJson(fn(AssertableJson $json) => $json->where('details.' . strval($i) . '.store', $store)
                        ->where('details.' . strval($i) . '.product', $product['name'])
                        ->where('details.' . strval($i) . '.price', $price)
                        ->where('details.' . strval($i) . '.quantity', $idx+1)
                        ->where('details.' . strval($i) . '.total', $price * ($idx+1)));
                    $i++;
                }
            }
        }
    }
}
