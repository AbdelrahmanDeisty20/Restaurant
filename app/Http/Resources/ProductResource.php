<?php

namespace App\Http\Resources;

use App\Http\Resources\ProductSizeResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // القاعدة: لو فيه أحجام → السعر يكون سعر أصغر حجم. مفيش أحجام → السعر الأصلي عادي
        // نستخدم relationLoaded للـ sizes عشان نتجنب السعر 0 لو مش محملة
        $hasSizes = $this->relationLoaded('sizes') && $this->sizes->isNotEmpty();
        $price = $hasSizes ? (float) $this->sizes->min('price') : (float) $this->price;

        // جلب الـ extras بناءً على الـ IDs المخزنة
        $extras = [];
        if (!empty($this->included_extras)) {
            $extraIds = is_array($this->included_extras) ? $this->included_extras : json_decode($this->included_extras, true);
            if (!empty($extraIds)) {
                $extras = \App\Models\ProductExtra::whereIn('id', $extraIds)->get();
            }
        }
        
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $price,
            'image_path' => $this->image_path,
            'time' => $this->time,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'offers' => OfferResource::collection($this->whenLoaded('offers')),
            'images' => ProductImagesResource::collection($this->whenLoaded('images')),
            'extras' => ProductExtraResource::collection($extras),
        ];
    }
}
