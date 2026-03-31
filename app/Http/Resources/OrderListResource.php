<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'order_number'      => $this->order_number,
            'status'            => $this->status,
            'payment_method'    => $this->payment_method,
            'customer_name'     => $this->customer_name,
            'customer_phone'    => $this->customer_phone,
            'delivery_address'  => $this->delivery_address,
            'notes'             => $this->notes,
            'sub_total'         => (float) $this->sub_total,
            'delivery_fees'     => (float) $this->delivery_fees,
            'total_discount'    => (float) $this->total_discount,
            'total_price'       => (float) $this->total_price,
            'created_at'        => $this->created_at->format('Y-m-d H:i:s'),
            'driver'            => new DriverResource($this->whenLoaded('driver')),
            'items'             => OrderItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
