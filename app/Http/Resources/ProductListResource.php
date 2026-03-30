<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ProductExtra;
use App\Http\Resources\ProductReviewResource;

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
        $price = (float) $this->price;
        if ($price <= 0) {
            $price = (float) ($this->sizes->min('price') ?: 0);
        }

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
            'reviews' => ProductReviewResource::collection($this->whenLoaded('productReviews')),
            'sizes' => ProductSizeResource::collection($this->sizes),
            'extras' => ProductExtraResource::collection($extrasData),
            'is_favorite' => auth('sanctum')->check() ? $this->favorites()->where('user_id', auth('sanctum')->id())->where('is_active', true)->exists() : false,
        ];
    }
}
