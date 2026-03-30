<?php

namespace App\Services;

use App\Http\Resources\OrderListResource;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function checkout(int $userId, array $data)
    {
        $cart = Cart::with(['items'])->where('user_id', $userId)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.cart_empty'),
                'data' => [],
            ];
        }

        // حساب الإجمايات مباشرة من الـ models لضمان الدقة وتجنب مشاكل الـ Resources
        $subTotal = collect($cart->items)->sum(fn($item) => $item->pivot->total_price);
        $totalDiscount = collect($cart->items)->sum(function ($item) {
            if ($item->pivot->product_size_id)
                return 0;
            if (($item->discount_price ?? 0) > 0) {
                return ($item->price - $item->discount_price) * $item->pivot->quantity;
            }
            return 0;
        });

        return DB::transaction(function () use ($userId, $data, $cart, $subTotal, $totalDiscount) {
            $order = Order::create([
                'order_number' => 'ORD-' . rand(100000, 999999),
                'user_id' => $userId,
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'delivery_address' => $data['delivery_address'],
                'delivery_lat' => $data['delivery_lat'] ?? null,
                'delivery_lng' => $data['delivery_lng'] ?? null,
                'payment_method' => $data['payment_method'] ?? 'cash',
                'sub_total' => $subTotal,
                'delivery_fees' => $data['delivery_fees'] ?? 0,
                'total_discount' => $totalDiscount,
                'total_price' => $subTotal + ($data['delivery_fees'] ?? 0),  // sub_total is already net (after unit discounts)
                'notes' => $data['notes'] ?? null,
                'status' => 'pending',
            ]);

            // تسجيل الحالة الأولى في السجل
            $order->statusHistories()->create([
                'status' => 'pending',
                'notes' => 'Order placed successfully',
            ]);

            foreach ($cart->items as $item) {
                $order->items()->attach($item->id, [
                    'quantity' => $item->pivot->quantity,
                    'price' => $item->pivot->unit_price,
                    'extras' => $item->pivot->extras,
                    'product_size_id' => $item->pivot->product_size_id,
                ]);
            }

            // مسح السلة بعد نجاح العملية
            $cart->items()->detach();

            return [
                'status' => true,
                'message' => __('messages.checkout_success'),
                'data' => new \App\Http\Resources\OrderResource($order->load(['items.category', 'items.sizes', 'items.images', 'items.offers', 'driver'])),
            ];
        });
    }

    public function getOrders($userId)
    {
        $orders = Order::where('user_id', $userId)->with(['items.category', 'items.images', 'items.offers', 'driver'])->get();
        return [
            'status' => true,
            'message' => __('messages.orders_retrieved_successfully'),
            'data' => OrderResource::collection($orders),
        ];
    }

    public function getOrder($userId, $orderId)
    {
        $order = Order::with(['items.category', 'items.images', 'items.offers', 'driver', 'statusHistories'])
            ->where('user_id', $userId)
            ->find($orderId);
        if (!$order) {
            return [
                'status' => false,
                'message' => __('messages.order_not_found'),
                'data' => [],
            ];
        }
        return [
            'status' => true,
            'message' => __('messages.order_retrieved_successfully'),
            'data' => new OrderListResource($order),
        ];
    }

    public function searchOrders($userId, $searchTerm)
    {
        $orders = Order::with(['items.category', 'items.images', 'items.offers', 'driver'])->where('user_id', $userId)
            ->where('order_number', 'like', "%{$searchTerm}%")
            ->paginate(10);

        if ($orders->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.order_not_found'),
                'data' => [],
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.orders_retrieved_successfully'),
            'data' => $orders,
        ];
    }
}
