<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ProductExtra;

class ProductListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // المنتج من الداخل (التفاصيل):
        // السعر: أقل حجم لو موجود، ولو مش موجود نعرض السعر الأصلي
        $hasSizes = $this->relationLoaded('sizes') && $this->sizes->isNotEmpty();
        $price = $hasSizes ? (float) $this->sizes->min('price') : (float) $this->price;

        $extrasData = [];
        if (!empty($this->included_extras)) {
            $extraIds = is_array($this->included_extras) ? $this->included_extras : json_decode($this->included_extras, true);
            if (!empty($extraIds)) {
                $extrasData = ProductExtra::whereIn('id', $extraIds)->get();
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
            // هنا بنعرض sizes و extras دايماً حتى لو المصفوفة فاضية
            'sizes' => ProductSizeResource::collection($this->sizes),
            'extras' => ProductExtraResource::collection($extrasData),
        ];
    }
}
