<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'order_id' => $this->id,
            'user_id' => $this->user_id,
            'total_price' => $this->totalPrice,
            'status' => $this->status,
            'address' => $this->address,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'products' => $this->products->map(function ($product) {
                return $product->pivot->toArray();
            }),
        ];
    }
}
