<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CheckCouponRequest;
use App\Http\Resources\CouponResource;
use App\Services\CartService;
use App\Services\CouponService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    use ApiResponse;

    protected $couponService;
    protected $cartService;

    public function __construct(CouponService $couponService, CartService $cartService)
    {
        $this->couponService = $couponService;
        $this->cartService = $cartService;
    }

    /**
     * List coupons that are active and available for the user.
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $now = now();

        $coupons = \App\Models\Coupon::where('is_active', true)
            ->where(function ($query) use ($now) {
                $query->whereNull('start_date')->orWhere('start_date', '<=', $now);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('end_date')->orWhere('end_date', '>=', $now);
            })
            ->where(function ($query) {
                $query->whereNull('usage_limit')->orWhereColumn('used_count', '<', 'usage_limit');
            })
            ->get();

        // Filter out coupons that the user has already used to their limit
        $availableCoupons = $coupons->filter(function ($coupon) use ($request) {
            return $coupon->isValidForUser($request->user());
        });

        return $this->success(CouponResource::collection($availableCoupons), __('messages.coupons_retrieved_successfully'));
    }

    /**
     * Check if a coupon is valid for the current user's cart.
     */
    public function check(CheckCouponRequest $request)
    {
        $userId = $request->user()->id;
        
        // Get current cart subtotal
        // We need to calculate it from the cart items
        $cart = \App\Models\Cart::with('items')->where('user_id', $userId)->first();
        
        if (!$cart || $cart->items->isEmpty()) {
            return $this->error(__('messages.cart_empty'), 400);
        }

        $subTotal = collect($cart->items)->sum(fn($item) => $item->pivot->total_price);

        $result = $this->couponService->check($request->code, $userId, $subTotal);

        if (!$result['status']) {
            return $this->error($result['message'], 400);
        }

        return $this->success($result['data'], $result['message']);
    }
}
