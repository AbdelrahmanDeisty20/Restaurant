<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class ProductReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => [
                'id' => $this->user_id,
                'name' => $this->user->name ?? null,
                'avatar' => $this->user->avatar_path ?? null,
            ],
            'product' => [
                'id' => $this->product_id,
                'name' => $this->product->name ?? null,
                'image_path' => $this->product->image_path ?? null,
                'is_favorite' => auth('sanctum')->check() ? $this->product->favorites()->where('user_id', auth('sanctum')->id())->where('is_active', true)->exists() : false,
            ],
            'rating' => $this->rating,
            'comment' => $this->comment,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
