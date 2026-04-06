<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'main_image',
        'category_id',
        'is_active',
        'is_featured',
        'price',
        'discount_price',
        'time',
        'included_extras',
    ];
    protected $casts = [
        'included_extras' => 'json',
    ];
    /*
    protected $appends = [
        'image_path',
        'name',
        'description',
    ];
    protected $hidden = [
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'main_image',
    ];
    */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getImagePathAttribute()
    {
        return asset('storage/products/main_image/' . $this->main_image);
    }

    public function getNameAttribute()
    {
        $locale = app()->getLocale();

        return $this->{"name_{$locale}"} ?? $this->name_en;
    }

    public function getDescriptionAttribute()
    {
        $locale = app()->getLocale();

        return $this->{"description_{$locale}"} ?? $this->description_en;
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function extras()
    {
        // This is now purely for reference if needed, but since it's global,
        // products don't "have" extras in the same way anymore.
        // We'll keep it empty or remove it if not used in APIs.
        return [];
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')->withPivot('quantity', 'extras', 'price');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class)->where('is_active', true)->where('end_date', '>=', now());
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function bestProductSeller()
    {
        return $this->hasOne(BestProductSeller::class);
    }
}
