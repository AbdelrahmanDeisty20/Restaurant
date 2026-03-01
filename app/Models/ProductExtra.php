<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductExtra extends Model
{
    protected $fillable = [
        'product_id',
        'name_ar',
        'name_en',
        'price',
        'type',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function getNameAttribute()
    {
        $locale = app()->getLocale();

        return $this->{"name_{$locale}"} ?? $this->name_en;
    }
}
