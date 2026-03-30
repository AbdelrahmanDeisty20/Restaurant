<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_phone',
        'delivery_address',
        'payment_method',
        'sub_total',
        'delivery_fees',
        'governorate_id',
        'total_discount',
        'total_price',
        'status',
        'notes',
        'driver_id',
        'delivery_lat',
        'delivery_lng',
        'estimated_delivery_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->belongsToMany(Product::class, 'order_items')->withPivot('quantity', 'extras', 'price', 'product_size_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(OrderStatusHistory::class);
    }
    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }
}
