<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'guest_token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this
            ->belongsToMany(Product::class, 'cart_items')
            ->withPivot('id', 'quantity', 'unit_price', 'total_price', 'extras')
            ->withTimestamps();
    }
}
