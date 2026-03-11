<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class OrderReviewResource extends JsonResource
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
            'order_id' => $this->order_id,
            'user' => [
                'id' => $this->user_id,
                'name' => $this->user->name ?? null,
            ],
            'rating' => $this->rating,
            'comment' => $this->comment,
            'product_reviews' => ProductReviewResource::collection($this->whenLoaded('productReviews')),
            'driver_reviews' => DriverReviewResource::collection($this->whenLoaded('driverReviews')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
