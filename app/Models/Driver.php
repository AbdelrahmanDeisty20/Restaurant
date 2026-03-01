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
    ];
    public function driverReviews()
    {
        return $this->hasMany(DriverReview::class);
    }
    public function getAvatarAttribute($value)
    {
        return asset('storage/drivers/avatars/' . $value);
    }
    public function getRatingAttribute($value)
    {
        return $this->driverReviews()->avg('rating');
    }
}
