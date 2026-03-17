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
        // القاعدة: في القائمة السعر = أقل سعر حجم أو السعر الأصلي
        $hasSizes = $this->relationLoaded('sizes') && $this->sizes->isNotEmpty();
        $price = $hasSizes ? (float) $this->sizes->min('price') : (float) $this->price;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $price,
            'image_path' => $this->image_path,
            'time' => $this->time,
            'offers' => OfferResource::collection($this->whenLoaded('offers')),
        ];
    }
}
