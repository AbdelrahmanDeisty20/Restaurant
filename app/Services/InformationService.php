<?php

namespace App\Services;

use App\Models\Page;
use App\Models\Setting;

class InformationService
{
    public function getPages()
    {
        return Page::all();
    }

    public function getPageBySlug($slug)
    {
        return Page::all();
    }

    public function getSettings()
    {
        $settings = Setting::all();
        return [
            'status' => true,
            'message' => 'success',
            'data' => new \App\Http\Resources\SettingResource($settings),
        ];
    }
}
