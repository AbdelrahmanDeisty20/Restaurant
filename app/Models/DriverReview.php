<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverReview extends Model
{
    protected $fillable = [
        'driver_id',
        'order_review_id',
        'rating',
        'comment',
    ];
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
    public function orderReview()
    {
        return $this->belongsTo(OrderReview::class);
    }
}
