<?php

namespace App\Http\Resources;

use App\Http\Resources\ProductSizeResource;
use App\Models\ProductSize;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class CartItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // الـ extras محفوظة كـ JSON objects {id, name, price}
        $extrasRaw = $this->pivot->extras ? json_decode($this->pivot->extras, true) : [];
        $extrasPrice = collect($extrasRaw)->sum('price');

        // الـ size المختار
        $size = null;
        $sizeModel = null;
        if ($this->pivot->product_size_id) {
            $sizeModel = ProductSize::find($this->pivot->product_size_id);
            $size = $sizeModel ? new ProductSizeResource($sizeModel) : null;
        }

        // السعر الأصلي: من الحجم لو موجود، وإلا من المنتج مباشرة
        $originalUnitPrice = $sizeModel
            ? (float) $sizeModel->price
            : (float) $this->price;

        // الخصم المحسوب — يستخدم فقط في total_price
        $discountMultiplier = 1.0;
        if ($this->relationLoaded('offers') && $this->offers->isNotEmpty()) {
            $offer = $this->offers->first();
            $discountMultiplier = 1 - $offer->discount_percentage / 100;
        }

        $quantity = $this->pivot->quantity;
        // unit_price = السعر الأصلي بدون خصم (حجم أو منتج)
        // total_price = بعد تطبيق الخصم + الإضافات × الكمية
        $discountedPrice = round($originalUnitPrice * $discountMultiplier, 2);
        $totalPrice = ($discountedPrice + $extrasPrice) * $quantity;

        $productData = new ProductResource($this->resource);

        return [
            'cart_item_id' => $this->pivot->id,
            'quantity' => $quantity,
            'size' => $size,
            'unit_price' => $originalUnitPrice,  // السعر الأصلي بدون خصم
            'extras_price' => round((float) $extrasPrice, 2),
            'total_price' => round($totalPrice, 2),  // بعد الخصم + الإضافات
            'extras' => $extrasRaw,
            'product' => $productData,
        ];
    }
}
