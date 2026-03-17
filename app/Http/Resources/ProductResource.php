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
        // القاعدة الجديدة: لو فيه أحجام أو إضافات → السعر في المنتج نفسه يكون 0
        $sizes = $this->whenLoaded('sizes');
        $hasSizes = is_iterable($sizes) && collect($sizes)->isNotEmpty();
        $hasExtras = !empty($this->included_extras);
        $price = ($hasSizes || $hasExtras) ? 0 : (float) $this->price;
        
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
            'sizes' => ProductSizeResource::collection($this->whenLoaded('sizes')),
        ];
    }
}
