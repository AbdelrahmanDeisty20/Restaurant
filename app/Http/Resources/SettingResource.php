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
        return $this->resource->mapWithKeys(function ($setting) {
            $value = $setting->value;

            // تطبيق منطق الصور إذا كان النوع صورة
            if ($setting->type === 'image' && $setting->value) {
                $value = asset('storage/settings/' . $setting->value);
            }

            return [$setting->key => $value];
        })->toArray();
    }
}
