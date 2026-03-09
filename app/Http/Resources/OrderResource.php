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
            'status' => $this->status,
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->customer_phone,
            'delivery_address' => $this->delivery_address,
            'payment_method' => $this->payment_method,
            'sub_total' => (float) $this->sub_total,
            'delivery_fees' => (float) $this->delivery_fees,
            'total_discount' => (float) $this->total_discount,
            'total_price' => (float) $this->total_price,
            'notes' => $this->notes,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
