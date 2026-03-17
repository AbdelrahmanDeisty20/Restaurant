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

        return [
            'id' => $this->id,
            'items' => CartItemResource::collection($this->whenLoaded('items')),
            'count' => $items->count(),
            'sub_total' => round($subTotal, 2),
        ];
    }
}
