<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_product()
    {
        $data = [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'quantity' => fake()->numberBetween(1, 1000),
            'price' => fake()->randomFloat(2, 1, 1000),
        ];

        $response = $this->postJson('/api/products', $data);
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' =>  $data['name']]);
    }

    public function test_can_update_product()
    {
        $product = Product::factory()->create();

        $data = [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'price' => fake()->randomFloat(2, 1, 1000),
        ];

        $response = $this->putJson("/api/products/{$product->id}", $data);
        $response->assertStatus(200);
        $response->assertJsonFragment(['message' => "Product updated successfully"]);
    }

    public function test_can_update_product_quantity()
    {
        $product = Product::factory()->create();
        $data = ['quantity' => 5];
        $response = $this->putJson("/api/products/{$product->id}/updateStock",$data);
        $response->assertStatus(200);
        $response->assertJsonFragment(['quantity' => $product->quantity + $data['quantity'] ]);
    }

    public function test_can_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->id}");
        $response->assertStatus(200);
        $response->assertJsonFragment(['message' => 'Product deleted successfully']);
    }

    public function test_can_show_product()
    {
        $product = Product::factory()->create();

        $response = $this->getJson("/api/products/{$product->id}");
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $product->name]);
    }

    public function test_notfound_show_product()
    {
        $productId = 99999999999999;

        $response = $this->getJson("/api/products/{$productId}");
        $response->assertStatus(404);
        $response->assertJsonFragment(['message' =>'Object Not Found']);
    }

}

