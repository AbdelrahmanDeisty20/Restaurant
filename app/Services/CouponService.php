<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\User;
use Exception;

class CouponService
{
    /**
     * Check if a coupon is valid and return its details.
     */
    public function check(string $code, int $userId, float $subTotal)
    {
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return [
                'status' => false,
                'message' => __('messages.coupon_not_found'),
                'data' => [],
            ];
        }

        if (!$coupon->is_active) {
            return [
                'status' => false,
                'message' => __('messages.coupon_not_active'),
                'data' => [],
            ];
        }

        $now = now();
        if ($coupon->start_date && $now->lt($coupon->start_date)) {
            return [
                'status' => false,
                'message' => __('messages.coupon_not_started'),
                'data' => [],
            ];
        }

        if ($coupon->end_date && $now->gt($coupon->end_date)) {
            return [
                'status' => false,
                'message' => __('messages.coupon_expired'),
                'data' => [],
            ];
        }

        if ($coupon->usage_limit !== null && $coupon->used_count >= $coupon->usage_limit) {
            return [
                'status' => false,
                'message' => __('messages.coupon_usage_limit_reached'),
                'data' => [],
            ];
        }

        $user = User::find($userId);
        if ($user) {
            $userUsage = $coupon->users()->where('user_id', $user->id)->count();
            if ($userUsage >= $coupon->user_usage_limit) {
                return [
                    'status' => false,
                    'message' => __('messages.coupon_user_usage_limit_reached'),
                    'data' => [],
                ];
            }
        }

        if ($subTotal < $coupon->min_order_value) {
            return [
                'status' => false,
                'message' => __('messages.coupon_min_order_value_not_reached', ['min' => $coupon->min_order_value]),
                'data' => [],
            ];
        }

        $discount = $coupon->calculateDiscount($subTotal);

        return [
            'status' => true,
            'message' => __('messages.coupon_valid'),
            'data' => [
                'coupon' => $coupon,
                'discount' => $discount,
                'new_sub_total' => $subTotal - $discount,
            ],
        ];
    }

    /**
     * Apply coupon usage.
     */
    public function applyUsage(Coupon $coupon, int $userId, int $orderId)
    {
        $coupon->increment('used_count');
        $coupon->users()->attach($userId, ['order_id' => $orderId]);
    }

    /**
     * Get basic coupon info and status without cart dependency.
     */
    public function getCouponInfo(string $code, ?int $userId = null)
    {
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return [
                'status' => false,
                'message' => __('messages.coupon_not_found'),
                'data' => null,
            ];
        }

        $isValid = $coupon->is_active;
        $message = $isValid ? __('messages.success') : __('messages.coupon_not_active');

        if ($isValid && $coupon->start_date && now()->lt($coupon->start_date)) {
            $isValid = false;
            $message = __('messages.coupon_not_started');
        }

        if ($isValid && $coupon->end_date && now()->gt($coupon->end_date)) {
            $isValid = false;
            $message = __('messages.coupon_expired');
        }

        if ($isValid && $coupon->usage_limit !== null && $coupon->used_count >= $coupon->usage_limit) {
            $isValid = false;
            $message = __('messages.coupon_usage_limit_reached');
        }

        if ($isValid && $userId) {
            $userUsage = $coupon->users()->where('user_id', $userId)->count();
            if ($userUsage >= $coupon->user_usage_limit) {
                $isValid = false;
                $message = __('messages.coupon_user_usage_limit_reached');
            }
        }

        return [
            'status' => true,
            'message' => $message,
            'data' => [
                'coupon' => $coupon,
                'is_valid' => $isValid,
            ],
        ];
    }
}
