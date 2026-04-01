<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BestProductSeller extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'image',
        'is_active',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        $override = $this->{"name_{$locale}"} ?? $this->name_en;
        
        return $override ?: ($this->product ? $this->product->name : null);
    }

    public function getDescriptionAttribute()
    {
        $locale = app()->getLocale();
        $override = $this->{"description_{$locale}"} ?? $this->description_en;

        return $override ?: ($this->product ? $this->product->description : null);
    }

    public function getImagePathAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        return $this->product ? $this->product->image_path : null;
    }
}
