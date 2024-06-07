<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_order()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'name' => 'Sample Product',
            'price' => 1000,
            'inventory' => 10,
        ]);

        $response = $this->actingAs($user, 'api')->postJson('/api/orders', [
            'products' => [
                ['id' => $product->id, 'count' => 2]
            ]
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['_id', 'user_id', 'products', 'total_price']);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
        ]);

        $product->refresh();
        $this->assertEquals(8, $product->inventory);
    }

    /** @test */
    public function user_cannot_create_order_with_insufficient_inventory()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'name' => 'Sample Product',
            'price' => 1000,
            'inventory' => 1,
        ]);

        $response = $this->actingAs($user, 'api')->postJson('/api/orders', [
            'products' => [
                ['id' => $product->id, 'count' => 6]
            ]
        ]);

        $response->assertStatus(201)
            ->assertJson(['original'=>['error' => 'Insufficient inventory for product: Sample Product']]);
    }
}
