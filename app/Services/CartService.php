<?php
namespace App\Services;

use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;

class CartService
{
    public function getCart($userId)
    {
        $cart = Cart::with('items.offers')->where('user_id', $userId)->first();
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

        $productSize = null;
        if (!empty($data['product_size_id'])) {
            $productSize = \App\Models\ProductSize::where('product_id', $product->id)
                ->find($data['product_size_id']);

            if (!$productSize) {
                return [
                    'status' => false,
                    'message' => __('messages.size_not_found_for_product'),
                    'data' => [],
                ];
            }
        }

        // Base price — الأولوية: حجم ← عرض فعال ← discount_price ← سعر أصلي
        if ($productSize) {
            $unitPrice = $productSize->price;
        } else {
            $activeOffer = $product->offers()->first();
            if ($activeOffer) {
                $basePrice = $product->price > 0 ? $product->price : $product->sizes()->min('price');
                $unitPrice = round($basePrice * (1 - $activeOffer->discount_percentage / 100), 2);
            } elseif (($product->discount_price ?? 0) > 0) {
                $unitPrice = $product->discount_price;
            } else {
                // لو السعر 0 وفيه أحجام، ناخد أقل سعر حجم كـ fallback (رغم إن الـ validation المفروض يمنع ده)
                $unitPrice = $product->price > 0 ? $product->price : ($product->sizes()->min('price') ?? 0);
            }
        }

        // Extras price
        $extrasData = [];
        $extrasPrice = 0;
        if (!empty($data['extras'])) {
            $selectedExtras = \App\Models\ProductExtra::findMany($data['extras']);
            foreach ($selectedExtras as $extra) {
                $extrasPrice += $extra->price;
                $extrasData[] = [
                    'id' => $extra->id,
                    'name' => $extra->name,
                    'price' => $extra->price,
                ];
            }
        }

        $totalUnitPrice = $unitPrice + $extrasPrice;
        $quantity = $data['quantity'];

        // Check for existing item with same product AND same size
        $existing = $cart
            ->items()
            ->where('product_id', $product->id)
            ->wherePivot('product_size_id', $data['product_size_id'] ?? null)
            ->first();

        if ($existing) {
            $newQty = $existing->pivot->quantity + $quantity;
            $cart->items()->updateExistingPivot($product->id, [
                'quantity' => $newQty,
                'total_price' => $totalUnitPrice * $newQty,
            ]);
        } else {
            $cart->items()->attach($product->id, [
                'quantity' => $quantity,
                'unit_price' => $unitPrice,  // سعر الحجم أو المنتج فقط
                'total_price' => ($unitPrice + $extrasPrice) * $quantity,  // شامل الإضافات
                'extras' => !empty($extrasData) ? json_encode($extrasData) : null,
                'product_size_id' => $data['product_size_id'] ?? null,
            ]);
        }

        $cart->load('items');
        return [
            'status' => true,
            'message' => __('messages.cart_item_added'),
            'data' => new CartResource($cart),
        ];
    }

    public function updateItem($userId, $productId, array $data)
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
            'quantity' => $data['quantity'],
            'total_price' => $unitPrice * $data['quantity'],
        ]);

        $cart->load('items');
        return [
            'status' => true,
            'message' => __('messages.cart_item_updated'),
            'data' => new CartResource($cart),
        ];
    }

    public function removeItem($userId, array $data)
    {
        $cart = Cart::where('user_id', $userId)->first();
        if (!$cart) {
            return ['status' => false, 'message' => __('messages.cart_empty'), 'data' => []];
        }

        $exists = $cart->items()->where('product_id', $data['product_id'])->exists();
        if (!$exists) {
            return ['status' => false, 'message' => __('messages.cart_item_not_found'), 'data' => []];
        }

        $cart->items()->detach($data['product_id']);
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
