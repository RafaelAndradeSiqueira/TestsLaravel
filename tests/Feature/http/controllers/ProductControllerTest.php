<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use \App\Exceptions\ProductTwoException;
use \App\Http\Controllers\ProductController;
use App\Models\Product;

class ProductControllerTest extends TestCase
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

    public function test_add_product_to_session_cart(): void
    {
        $product = Product::factory()->create();

        $response = $this->post("/products/{$product->id}/add");

        $response->assertStatus(200);

        $response->assertJson([
            'message' => 'Product added to cart'
        ]);

        $this->assertContains($product->id, session('cart'));
    }

    public function test_get_products_from_cart(): void
    {
        $products = Product::factory()->count(2)->create();

        $cartIds = $products->pluck('id')->toArray();

        $response = $this->withSession([
            'cart' => $cartIds
        ])->get('/cart');

        $response->assertStatus(200);

        $response->assertJsonCount(2);
    }

    public function test_products_in_cart_throws_exception_when_cart_has_3_products(): void
    {
        $products = Product::factory()->count(3)->create();

        session([
            'cart' => $products->pluck('id')->toArray()
        ]);

        $this->expectException(ProductTwoException::class);
        $this->expectExceptionMessage('Você não pode adicionar mais de 3 produtos ao carrinho.');

        app(ProductController::class)->productsInCart();
    }
}
