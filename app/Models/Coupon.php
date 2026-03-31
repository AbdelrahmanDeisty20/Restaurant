<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'max_discount',
        'min_order_value',
        'start_date',
        'end_date',
        'usage_limit',
        'user_usage_limit',
        'used_count',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'value' => 'float',
        'max_discount' => 'float',
        'min_order_value' => 'float',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'coupon_user')
            ->withPivot('order_id')
            ->withTimestamps();
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();
        if ($this->start_date && $now->lt($this->start_date)) {
            return false;
        }

        if ($this->end_date && $now->gt($this->end_date)) {
            return false;
        }

        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    public function isValidForUser(User $user): bool
    {
        if (!$this->isValid()) {
            return false;
        }

        $userUsage = $this->users()->where('user_id', $user->id)->count();
        if ($userUsage >= $this->user_usage_limit) {
            return false;
        }

        return true;
    }

    public function calculateDiscount(float $subTotal): float
    {
        if ($subTotal < $this->min_order_value) {
            return 0;
        }

        $discount = 0;
        if ($this->type === 'fixed') {
            $discount = $this->value;
        } elseif ($this->type === 'percentage') {
            $discount = ($subTotal * $this->value) / 100;
            if ($this->max_discount !== null && $discount > $this->max_discount) {
                $discount = $this->max_discount;
            }
        }

        return min($discount, $subTotal);
    }
}
