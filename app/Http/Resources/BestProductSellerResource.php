<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class BestProductSellerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product = $this->product;
        if (!$product)
            return [];

        // السعر: أقل حجم لو موجود، ولو مش موجود نعرض السعر الأصلي (كما في ProductResource)
        $price = (float) $product->price;
        if ($price <= 0) {
            $price = (float) ($product->sizes->min('price') ?: 0);
        }

        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'name' => $this->name,  // من الموديل الجديد (Override fallback)
            'description' => $this->description,  // من الموديل الجديد (Override fallback)
            'price' => $price,
            'image_path' => $this->image_path,  // من الموديل الجديد (Override fallback)
            'time' => $product->time,
            'is_favorite' => auth('sanctum')->check() ? $product->favorites()->where('user_id', auth('sanctum')->id())->where('is_active', true)->exists() : false,
            'is_active' => $this->is_active,
        ];
    }
}
