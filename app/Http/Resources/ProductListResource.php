<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // منطق السعر: لو فيه أحجام -> السعر = سعر أصغر حجم. مفيش -> السعر الأصلي.
        $hasSizes = $this->relationLoaded('sizes') && $this->sizes->isNotEmpty();
        
        $price = $hasSizes ? (float) $this->sizes->min('price') : (float) $this->price;

        // جلب الـ extras بناءً على الـ IDs المخزنة
        $extrasData = [];
        if (!empty($this->included_extras)) {
            $extraIds = is_array($this->included_extras) ? $this->included_extras : json_decode($this->included_extras, true);
            if (!empty($extraIds)) {
                $extrasData = \App\Models\ProductExtra::whereIn('id', $extraIds)->get();
            }
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $price,
            'image_path' => $this->image_path,
            'time' => $this->time,
            'offers' => OfferResource::collection($this->whenLoaded('offers')),
            'sizes' => ProductSizeResource::collection($this->whenLoaded('sizes')),
            'extras' => ProductExtraResource::collection($extrasData),
        ];
    }
}
