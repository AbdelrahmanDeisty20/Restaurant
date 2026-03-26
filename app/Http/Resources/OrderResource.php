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
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
