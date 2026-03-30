<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'status' => $this->status,
            'total_price' => (float) $this->total_price,
            'delivery_fees' => (float) ($this->governorate->delivery_fee ?? 0),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'driver' => new DriverResource($this->whenLoaded('driver')),
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
