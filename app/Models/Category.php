<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'image',
        'is_active',
    ];
    protected $appends = ['name', 'image_path'];
    protected $hidden = ['name_ar', 'name_en', 'image'];
    public function getNameAttribute()
    {
        $locale = app()->getLocale();

        return $this->{"name_{$locale}"} ?? $this->name_en;
    }
    public function getImagePathAttribute()
    {
        return asset('storage/categories/' . $this->image);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
