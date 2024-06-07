<?php

// App/Services/OrderService.php
namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrder($userId, array $products)
    {
        $totalPrice = 0;
        $productDetails = [];

        try {
            foreach ($products as $productData) {
                $product = Product::find($productData['id']);
                if ($product->inventory < $productData['count']) {
                    return response()->json(['error' => 'Insufficient inventory for product: ' . $product->name], 400);
                }

                $totalPrice += $product->price * $productData['count'];
                $productDetails[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'count' => $productData['count']
                ];

                $product->inventory -= $productData['count'];
                $product->save();
            }

            $order = Order::create([
                'user_id' => $userId,
                'products' => $productDetails,
                'total_price' => $totalPrice,
            ]);

            return $order;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
