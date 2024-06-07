<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_product()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->postJson('/api/products', [
            'name' => 'Sample Product',
            'price' => 1000,
            'inventory' => 10,
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['_id', 'name', 'price', 'inventory']);

        $this->assertDatabaseHas('products', [
            'name' => 'Sample Product',
        ]);
    }

    /** @test */
    public function user_can_view_products()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['_id', 'name', 'price', 'inventory']
            ]);
    }

    /** @test */
    public function user_can_update_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'name' => 'Sample Product',
            'price' => 1000,
            'inventory' => 10,
        ]);

        $response = $this->actingAs($user, 'api')->putJson("/api/products/{$product->id}", [
            'name' => 'Updated Product',
            'price' => 1500,
            'inventory' => 20,
        ]);

        $response->assertStatus(200)
            ->assertJson(['name' => 'Updated Product']);

        $this->assertDatabaseHas('products', [
            'name' => 'Updated Product',
        ]);
    }

    /** @test */
    public function user_can_delete_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'name' => 'Sample Product',
            'price' => 1000,
            'inventory' => 10,
        ]);

        $response = $this->actingAs($user, 'api')->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('products', [
            'name' => 'Sample Product',
        ]);
    }
}
