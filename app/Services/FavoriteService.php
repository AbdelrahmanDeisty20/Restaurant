<?php

namespace App\Services;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class FavoriteService
{
    /**
     * Toggle favorite status of a product for a specific user.
     *
     * @param int $userId
     * @param int $productId
     * @return array
     */
    public function toggleFavorite(int $userId, int $productId)
    {
        $product = Product::with('productReviews')->find($productId);
        if (!$product) {
            return [
                'status' => false,
                'message' => __('messages.product_not_found'),
                'data' => []
            ];
        }

        $favorite = Favorite::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($favorite) {
            $favorite->update(['is_active' => !$favorite->is_active]);
            $message = $favorite->is_active ? __('messages.added_to_favorites') : __('messages.removed_from_favorites');
            return [
                'status' => true,
                'message' => $message,
                'data' => new \App\Http\Resources\FavoriteResource($favorite->load('product'))
            ];
        }

        $favorite = Favorite::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'is_active' => true,
        ]);

        return [
            'status' => true,
            'message' => __('messages.added_to_favorites'),
            'data' => new \App\Http\Resources\FavoriteResource($favorite->load('product'))
        ];
    }

    /**
     * Get the list of favorite products for a specific user.
     *
     * @param int $userId
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getFavorites(int $userId)
    {
        return Favorite::where('user_id', $userId)
            ->with(['product.category', 'product.images', 'product.sizes', 'product.offers'])
            ->latest()
            ->paginate(10);
    }
}
