<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // المنتج من الخارج (القائمة العامة): 
        // السعر: أقل حجم لو موجود، ولو مش موجود نعرض السعر الأصلي
        $hasSizes = $this->relationLoaded('sizes') && $this->sizes->isNotEmpty();
        $price = $hasSizes ? (float) $this->sizes->min('price') : (float) $this->price;

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
            // هنا مفيش sizes ومفيش extras زى ما طلبت
        ];
    }
}
