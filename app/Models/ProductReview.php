<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $fillable = [
        'order_review_id',
        'user_id',
        'product_id',
        'rating',
        'comment',
    ];
    public function orderReview()
    {
        return $this->belongsTo(OrderReview::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
