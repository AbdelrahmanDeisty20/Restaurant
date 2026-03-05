<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'images',
        'sort',
    ];
    protected $appends = ['images_path'];
    protected $hidden = ['images'];
    public function variant()
    {
        return $this->belongsTo(Product::class);
    }
    public function getImagesPathAttribute()
    {
        return asset('storage/products/images/' . $this->images);
    }
}