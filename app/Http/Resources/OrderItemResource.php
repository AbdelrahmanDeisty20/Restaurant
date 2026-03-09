<?php

namespace App\Http\Resources;

use App\Models\ProductSize;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class OrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $extrasRaw = $this->pivot->extras ? json_decode($this->pivot->extras, true) : [];

        $size = null;
        if ($this->pivot->product_size_id) {
            $sizeModel = ProductSize::find($this->pivot->product_size_id);
            $size = $sizeModel ? new ProductSizeResource($sizeModel) : null;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'quantity' => $this->pivot->quantity,
            'unit_price' => (float) $this->pivot->price,
            'size' => $size,
            'extras' => $extrasRaw,
            'product' => new ProductResource($this->resource),
        ];
    }
}
