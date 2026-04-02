<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'avatar',
        'rating',
        'status',
        'current_lat',
        'current_lng',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
