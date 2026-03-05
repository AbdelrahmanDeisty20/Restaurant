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
        return [
            'id'=>$this->id,
            'name' => $this->name,
            'price' => $this->price,
            'category' => CategoryResource::collection($this->whenLoaded('category')),
            'description' => $this->description,
            "offer"=>OfferResource::collection($this->whenLoaded('offer')),
            "time"=>$this->time,
            "discount_price"=>(float)$this->discount_price,
            "image_path"=>$this->image_path,
            'images_path'=>new ProductImagesResource($this->whenLoaded('images')),
        ];
    }
}
