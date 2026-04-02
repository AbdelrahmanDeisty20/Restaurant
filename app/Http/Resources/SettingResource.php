<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $value = $this->value;

        // تحويل الصورة لرابط كامل إذا كانت من نوع image
        if ($this->type === 'image' && $this->value) {
            $value = asset('storage/settings/' . $this->value);
        }

        return [
            'key' => $this->key,
            'value' => $value,
            'type' => $this->type,
        ];
    }
}
