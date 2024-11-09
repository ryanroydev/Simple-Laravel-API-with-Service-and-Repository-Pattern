<?php

namespace Tests\Feature;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiUnauthenticatedTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_product_unauthenticated()
    {
        $data = [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'quantity' => fake()->numberBetween(1, 1000),
            'price' => fake()->randomFloat(2, 1, 1000),
        ];


        $response = $this->postJson('/api/products', $data);
        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

    public function test_can_update_product_unauthenticated()
    {
        $product = Product::factory()->create();

        $data = [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'price' => fake()->randomFloat(2, 1, 1000),
        ];


        $response = $this->putJson("/api/products/{$product->id}", $data);

        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

    public function test_can_update_product_quantity_unauthenticated()
    {
        $product = Product::factory()->create();
        $data = ['quantity' => 5];

        $response = $this->putJson("/api/products/{$product->id}/updateStock",$data);

        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

    public function test_can_delete_product_unauthenticated()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

    public function test_can_show_product_unauthenticated()
    {
        $product = Product::factory()->create();

        $response = $this->getJson("/api/products/{$product->id}");

        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

}

