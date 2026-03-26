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
        $price = (float) $this->price;
        if ($price <= 0) {
            $price = (float) ($this->sizes->min('price') ?: 0);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $price,
            'image_path' => $this->image_path,
            'time' => $this->time,
            'reviews' => ProductReviewResource::collection($this->whenLoaded('productReviews')),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'offers' => OfferResource::collection($this->whenLoaded('offers')),
            'images' => ProductImagesResource::collection($this->whenLoaded('images')),
            // هنا مفيش sizes ومفيش extras زى ما طلبت
        ];
    }
}
