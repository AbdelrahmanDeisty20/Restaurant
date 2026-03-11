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
        return Page::where('slug', $slug)->first();
    }

    public function getSettings()
    {
        return Setting::pluck('value', 'key')->all();
    }
}
