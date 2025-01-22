<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BasketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'basket_id' => $this->id,
            'user_id' => $this->user_id,
            'totalPrice' => $this->totalPrice,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'products' => $this->products->map(function ($product) {
                return $product->pivot->toArray();
            }),
        ];
    }
}
