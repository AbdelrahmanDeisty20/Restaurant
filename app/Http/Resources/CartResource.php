<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class CartResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $items = $this->items;

        // مجموع ما دُفع فعلاً
        $subTotal = $items->sum(fn($item) => $item->pivot->total_price);

        $totalDiscount = $items->sum(function ($item) {
            if ($item->pivot->product_size_id) return 0;
            return max($item->price - $item->pivot->unit_price, 0) * $item->pivot->quantity;
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
