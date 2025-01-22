<?php

namespace App\Http\Services;

use App\Jobs\RedisClient;
use App\Models\Order;
use App\Models\Basket;
use ErrorException;
use Illuminate\Support\Facades\Redis;

class OrderService
{
    public function createOrder($userId, $address)
    {
        $basket = Basket::with('products')->where('user_id', $userId)->first();

        if (!$basket || $basket->products->isEmpty()) {
            throw new ErrorException('Basket is empty or not found');
        }

        $order = Order::create([
            'user_id' => $userId,
            'totalPrice' => $basket->totalPrice,
            'status' => 'pending',
            'address' => $address,
        ]);

        foreach ($basket->products as $product) {
            $order->products()->attach($product->id, [
                'quantity' => $product->pivot->quantity,
                'price' => $product->pivot->price,
            ]);
        }

        $basket->products()->detach();
        $basket->totalPrice = 0;
        $basket->save();

        RedisClient::dispatch('order_created', $order);
        return $order;
    }

    public function getOrders($userId)
    {
        return Order::with('products')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
