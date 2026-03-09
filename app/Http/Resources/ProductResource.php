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
        // لو فيه أحجام → السعر = أقل سعر من الأحجام
        $sizes = $this->whenLoaded('sizes');
        $hasSizes = is_iterable($sizes) && collect($sizes)->isNotEmpty();

        $price = $hasSizes ? (float) collect($sizes)->min('price') : (float) $this->price;
        $discountPrice = $hasSizes ? null : (float) $this->discount_price;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $price,
            'discount_price' => $discountPrice,
            'image_path' => $this->image_path,
            'time' => $this->time,
            'included_extras' => $this->included_extras,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'offers' => OfferResource::collection($this->whenLoaded('offers')),
            'images' => ProductImagesResource::collection($this->whenLoaded('images')),
            'sizes' => ProductSizeResource::collection($this->whenLoaded('sizes')),
        ];
    }
}
