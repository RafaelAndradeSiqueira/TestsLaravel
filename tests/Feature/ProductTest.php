<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_index_products(): void
    {

        $response = $this->get('/products');

        $response->assertStatus(200);
    }

    public function test_store_product(): void
    {
        $response = $this->post('/products', [
            'name' => 'Test Product',
            'description' => 'This is a test product.',
            'price' => 99.99,
        ]);

        $response->assertStatus(201);
    }

    public function test_store_10_products(): void
    {
        $product = Product::factory()->count(10)->create();

        $this->assertEquals(10, $product->count());

    }

    public function test_store_10_products_with_database_count(): void
    {
        Product::factory()->count(10)->create();

        $this->assertDatabaseCount('products', 10);

    }

    public function test_destroy_product(): void
    {
        $product = Product::factory()->create();

        $response = $this->delete("/products/{$product->id}");

        $response->assertStatus(204);
    }
}
