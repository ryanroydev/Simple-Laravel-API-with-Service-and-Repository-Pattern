<?php

namespace Tests\Feature;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    protected function createAuthenticatedUserToken(){

       $user =  User::factory()->create();

       return $user->createToken('laravel-api')->plainTextToken;
    }

    public function test_can_create_product()
    {
        $data = [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'quantity' => fake()->numberBetween(1, 1000),
            'price' => fake()->randomFloat(2, 1, 1000),
        ];

        $token = $this->createAuthenticatedUserToken();

        $response = $this->postJson('/api/products', $data,[
            'Authorization' => "Bearer $token"
        ]);
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

        $token = $this->createAuthenticatedUserToken();

        $response = $this->putJson("/api/products/{$product->id}", $data,[
            'Authorization' => "Bearer $token"
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['message' => "Product updated successfully"]);
    }

    public function test_can_update_product_quantity()
    {
        $product = Product::factory()->create();
        $data = ['quantity' => 5];

        $token = $this->createAuthenticatedUserToken();

        $response = $this->putJson("/api/products/{$product->id}/updateStock",$data,[
            'Authorization' => "Bearer $token"
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['quantity' => $product->quantity + $data['quantity'] ]);
    }

    public function test_can_delete_product()
    {
        $product = Product::factory()->create();

        $token = $this->createAuthenticatedUserToken();

        $response = $this->deleteJson("/api/products/{$product->id}", [], [
            'Authorization' => "Bearer $token"
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['message' => 'Product deleted successfully']);
    }

    public function test_can_show_product()
    {
        $product = Product::factory()->create();

        $token = $this->createAuthenticatedUserToken();

        $response = $this->getJson("/api/products/{$product->id}",[
            'Authorization' => "Bearer $token"
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $product->name]);
    }

    public function test_notfound_show_product()
    {
        $productId = 99999999999999;

        $token = $this->createAuthenticatedUserToken();

        $response = $this->getJson("/api/products/{$productId}",[
            'Authorization' => "Bearer $token"
        ]);

        $response->assertStatus(404);
        $response->assertJsonFragment(['message' =>'Object Not Found']);
    }

}

