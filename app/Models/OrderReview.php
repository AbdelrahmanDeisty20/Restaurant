<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderReview extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'rating',
        'comment',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }
    public function driverReviews()
    {
        return $this->hasMany(DriverReview::class);
    }
}
