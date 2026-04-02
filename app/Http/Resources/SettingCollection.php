<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SettingCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->mapWithKeys(function ($setting) {
            $value = $setting->value;
            if ($setting->type === 'image' && $setting->value) {
                $value = asset('storage/settings/' . $setting->value);
            }
            return [$setting->key => $value];
        })->toArray();
    }
}
