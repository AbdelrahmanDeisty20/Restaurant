<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'avatar',
        'rating',
        'status',
        'current_lat',
        'current_lng',
    ];

    public function driverReviews()
    {
        return $this->hasMany(DriverReview::class);
    }

    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? asset('storage/' . $this->avatar) : null;
    }

    public function getRatingAttribute($value)
    {
        return $this->driverReviews()->avg('rating');
    }
}
