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

        // الخصم = (السعر الأصلي - سعر الخصم) × الكمية
        // لو اختار حجم → مفيش خصم (سعر الحجم هو الأساس)
        // لو مفيش حجم وفيه discount_price → يحسب الخصم
        $totalDiscount = $items->sum(function ($item) {
            if ($item->pivot->product_size_id) {
                return 0;  // سعر الحجم مش بيتطبق عليه خصم المنتج
            }
            if (($item->discount_price ?? 0) > 0) {
                return ($item->price - $item->discount_price) * $item->pivot->quantity;
            }
            return 0;
        });

        return [
            'id' => $this->id,
            'items' => CartItemResource::collection($this->whenLoaded('items')),
            'count' => $items->count(),
            'total_discount' => round(max($totalDiscount, 0), 2),
            'sub_total' => round($subTotal, 2),
        ];
    }
}
