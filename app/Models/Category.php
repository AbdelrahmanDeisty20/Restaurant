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

    protected $hidden = [
        'name_ar',
        'name_en',
        'image',
    ];

    public function getNameAttribute()
    {
        $locale = app()->getLocale();

        return $this->{"name_{$locale}"} ?? $this->name_en;
    }

    public function getImagePathAttribute()
    {
        if (!$this->image) {
            return null;
        }

        // Handle both bare filenames (seeded: yemeni.jpg) and full paths (Filament: categories/xyz.jpg)
        // This solves the "categories/categories/" duplication issue.
        $path = str_starts_with($this->image, 'categories/')
            ? $this->image
            : 'categories/' . $this->image;

        // Correct public URL path - WITHOUT 'app/public'
        return asset('storage/' . $path);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
