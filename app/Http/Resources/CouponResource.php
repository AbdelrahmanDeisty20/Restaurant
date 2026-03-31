<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
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
            'code' => $this->code,
            'type' => $this->type,
            'value' => $this->value,
            'max_discount' => $this->max_discount,
            'min_order_value' => $this->min_order_value,
            'start_date' => $this->start_date ? $this->start_date->toIso8601String() : null,
            'end_date' => $this->end_date ? $this->end_date->toIso8601String() : null,
            'usage_limit' => $this->usage_limit,
            'used_count' => $this->used_count,
            'user_usage_limit' => $this->user_usage_limit,
            'is_active' => $this->is_active,
            'is_valid_for_user' => $request->user() ? $this->isValidForUser($request->user()) : $this->isValid(),
        ];
    }
}
