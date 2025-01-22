<?php
namespace App\Http\Services;

use App\Models\Basket;

class BasketService
{
    public function updateBasket($product_id, $product_quantity, $totalPrice, $user_id)
    {
        $basket = Basket::firstOrCreate(['user_id' => $user_id]);
        $isHave = $basket->products()->where('product_id', $product_id)->first();

        if ($isHave) {
            $newQuantity = $isHave->pivot->quantity + $product_quantity;
            $newPrice = $isHave->pivot->price + $totalPrice;

            $basket->products()->updateExistingPivot($product_id, ['quantity' => $newQuantity, 'price' => $newPrice]);
        } else {
            $basket->products()->attach($product_id, ['quantity' => $product_quantity, 'price' => $totalPrice]);
            $basket->totalPrice += $totalPrice;
            $basket->save();
        }
    }
}
