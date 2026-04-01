<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class OrderTrackingResource extends JsonResource
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
            'status' => $this->status,
            'estimated_delivery_time' => $this->estimated_delivery_time ? $this->estimated_delivery_time->format('H:i') : null,
            'delivery_address' => $this->delivery_address,
            'delivery_coords' => [
                'lat' => (float) $this->delivery_lat,
                'lng' => (float) $this->delivery_lng,
            ],
            'restaurant_coords' => [
                'lat' => (float) \App\Models\Setting::getValue('restaurant_lat', 30.0444),
                'lng' => (float) \App\Models\Setting::getValue('restaurant_lng', 31.2357),
            ],
            'driver' => $this->driver ? [
                'id' => $this->driver->id,
                'name' => $this->driver->name,
                'phone' => $this->driver->phone,
                'avatar' => $this->driver->avatar_url,
                'rating' => (float) $this->driver->rating,
                'location' => [
                    'lat' => (float) $this->driver->current_lat,
                    'lng' => (float) $this->driver->current_lng,
                ],
            ] : null,
            'timeline' => OrderStatusHistoryResource::collection($this->whenLoaded('statusHistories')),
            'items' => OrderItemResource::collection($this->whenLoaded('orderItems')),  // Note: custom relation name or items
            'total_price' => (float) $this->total_price,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
