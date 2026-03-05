<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class CartItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'cart_item_id' => $this->pivot->id,
            'quantity' => $this->pivot->quantity,
            'unit_price' => (float) $this->pivot->unit_price,
            'total_price' => (float) $this->pivot->total_price,
            'extras' => $this->pivot->extras ? json_decode($this->pivot->extras) : null,
            'product' => new ProductResource($this->resource),
        ];
    }
}
