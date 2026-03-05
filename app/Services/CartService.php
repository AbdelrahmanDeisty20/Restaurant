<?php
namespace App\Services;

use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;

class CartService
{
    public function getCart($userId)
    {
        $cart = Cart::with('items')->where('user_id', $userId)->first();
        if (!$cart || $cart->items->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.cart_empty'),
                'data' => [],
            ];
        }
        return [
            'status' => true,
            'message' => __('messages.cart_retrieved_successfully'),
            'data' => new CartResource($cart),
        ];
    }

    public function addItem($userId, array $data)
    {
        $product = Product::find($data['product_id']);
        if (!$product) {
            return [
                'status' => false,
                'message' => __('messages.product_not_found'),
                'data' => [],
            ];
        }

        $cart = Cart::firstOrCreate(['user_id' => $userId]);

        $unitPrice = $product->discount_price > 0 ? $product->discount_price : $product->price;
        $quantity = $data['quantity'];
        $extras = $data['extras'] ?? null;

        // لو المنتج موجود في السلة → نزيد الكمية
        $existing = $cart->items()->where('product_id', $product->id)->first();

        if ($existing) {
            $newQty = $existing->pivot->quantity + $quantity;
            $cart->items()->updateExistingPivot($product->id, [
                'quantity' => $newQty,
                'total_price' => $unitPrice * $newQty,
            ]);
        } else {
            $cart->items()->attach($product->id, [
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'total_price' => $unitPrice * $quantity,
                'extras' => $extras ? json_encode($extras) : null,
            ]);
        }

        $cart->load('items');
        return [
            'status' => true,
            'message' => __('messages.cart_item_added'),
            'data' => new CartResource($cart),
        ];
    }

    public function updateItem($userId, $productId, $quantity)
    {
        $cart = Cart::where('user_id', $userId)->first();
        if (!$cart) {
            return ['status' => false, 'message' => __('messages.cart_empty'), 'data' => []];
        }

        $product = $cart->items()->where('product_id', $productId)->first();
        if (!$product) {
            return ['status' => false, 'message' => __('messages.product_not_found'), 'data' => []];
        }

        $unitPrice = $product->pivot->unit_price;
        $cart->items()->updateExistingPivot($productId, [
            'quantity' => $quantity,
            'total_price' => $unitPrice * $quantity,
        ]);

        $cart->load('items');
        return [
            'status' => true,
            'message' => __('messages.cart_item_updated'),
            'data' => new CartResource($cart),
        ];
    }

    public function removeItem($userId, $productId)
    {
        $cart = Cart::where('user_id', $userId)->first();
        if (!$cart) {
            return ['status' => false, 'message' => __('messages.cart_empty'), 'data' => []];
        }

        $cart->items()->detach($productId);
        $cart->load('items');
        return [
            'status' => true,
            'message' => __('messages.cart_item_removed'),
            'data' => new CartResource($cart),
        ];
    }

    public function clearCart($userId)
    {
        $cart = Cart::where('user_id', $userId)->first();
        if ($cart) {
            $cart->items()->detach();
        }
        return [
            'status' => true,
            'message' => __('messages.cart_cleared'),
            'data' => [],
        ];
    }
}
