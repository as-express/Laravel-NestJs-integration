<?php
namespace App\Http\Services;
use App\Http\Resources\BasketResource;
use App\Http\Resources\OrderResource;
use App\Models\Basket;
use App\Models\Order;
use ErrorException;

class UserService
{
    public function getBasket($userId)
    {
        $basket = Basket::with('products')->where('user_id', $userId)->first();

        if (!$basket) {
            throw new ErrorException('Basket Not Found');
        }

        return new BasketResource($basket);
    }

    public function getOrders($userId)
    {
        $order = Order::with('products')->where('user_id', $userId)->first();
        if (!$order) {
            throw new ErrorException('Orders Not Found');
        }
        return new OrderResource($order);
    }
}
