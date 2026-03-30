<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'delivery_fee',
    ];

    public function getNameAttribute()
    {
        $locale = app()->getLocale();

        return $this->{"name_{$locale}"} ?? $this->name_en;
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
