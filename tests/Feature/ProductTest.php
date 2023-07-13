<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function testGetAllProducts()
    {
        $products = Product::factory()->count(3)->create();

        $response = $this->get('/api/products');

        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJson($products->toArray());
    }

    public function testGetProductById()
    {
        $product = Product::factory()->create();

        $response = $this->get('/api/products/' . $product->id);

        $response->assertStatus(200)
            ->assertJson($product->toArray());
    }

    public function testCreateProduct()
    {
        $productData = [
            'name' => 'New Product',
            'description' => 'This is a new product',
            'price' => 10.99,
        ];

        $response = $this->post('/api/products', $productData);

        $response->assertStatus(201)
            ->assertJson($productData);
    }

    public function testUpdateProduct()
    {
        $product = Product::factory()->create();

        $updatedData = [
            'name' => 'Updated Product',
            'description' => 'This product has been updated',
            'price' => 19.99,
        ];

        $response = $this->put('/api/products/' . $product->id, $updatedData);

        $response->assertStatus(200)
            ->assertJson($updatedData);
    }

    public function testDeleteProduct()
    {
        $product = Product::factory()->create();

        $response = $this->delete('/api/products/' . $product->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
