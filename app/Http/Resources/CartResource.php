<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class CartResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $items = $this->items;

        $subTotal = $items->sum(fn($item) => $item->pivot->total_price);

        $totalDiscount = $items->sum(function ($item) {
            $originalTotal = $item->price * $item->pivot->quantity;
            return $originalTotal - $item->pivot->total_price;
        });

        return [
            'id' => $this->id,
            'items' => CartItemResource::collection($this->whenLoaded('items')),
            'count' => $items->count(),
            'total_discount' => round($totalDiscount, 2),
            'sub_total' => round($subTotal, 2),
        ];
    }
}
