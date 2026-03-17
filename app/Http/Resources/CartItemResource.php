<?php

namespace App\Http\Resources;

use App\Http\Resources\ProductResource;
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
        if ($this->pivot->product_size_id) {
            $sizeModel = ProductSize::find($this->pivot->product_size_id);
            $size = $sizeModel ? new ProductSizeResource($sizeModel) : null;
        }

        $originalUnitPrice = $this->pivot->product_size_id && $sizeModel 
            ? (float) $sizeModel->price 
            : (float) $this->price;

        $paidUnitPrice = (float) $this->pivot->unit_price; // السعر من الـ pivot هو اللي بعد الخصم
        $quantity = $this->pivot->quantity;
        $totalPrice = ($paidUnitPrice + $extrasPrice) * $quantity;

        return [
            'cart_item_id' => $this->pivot->id,
            'quantity' => $quantity,
            'size' => $size,
            'unit_price' => $originalUnitPrice, // السعر الأصلي كما طلب المستخدم
            'discount_price' => $paidUnitPrice, // السعر بعد الخصم (العرض)
            'extras_price' => round((float) $extrasPrice, 2),
            'total_price' => round($totalPrice, 2), // الإجمالي الفعلي المدفوع
            'extras' => $extrasRaw,
            'product' => new ProductResource($this->resource),
        ];
    }
}
