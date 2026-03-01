<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title_ar',
        'title_en',
        'content_ar',
        'content_en',
        'sections',
    ];
    protected $casts = [
        'sections' => 'array',
    ];
    public function getTitleAttribute()
    {
        $locale = app()->getLocale();

        return $this->{"title_{$locale}"} ?? $this->title_en;
    }
    public function getContentAttribute()
    {
        $locale = app()->getLocale();

        return $this->{"content_{$locale}"} ?? $this->content_en;
    }
    public function getSectionsAttribute($value)
    {
        return json_decode($value, true);
    }
}
