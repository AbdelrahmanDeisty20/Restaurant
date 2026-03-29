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
            $favorite->delete();
            return [
                'status' => true,
                'message' => __('messages.removed_from_favorites'),
                'data' => []
            ];
        }

        Favorite::create([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);

        return [
            'status' => true,
            'message' => __('messages.added_to_favorites'),
            'data' => []
        ];
    }

    /**
     * Get the list of favorite products for a specific user.
     *
     * @param int $userId
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getFavorites(int $userId, int $perPage = 15)
    {
        return Favorite::where('user_id', $userId)
            ->with(['product.category', 'product.images', 'product.sizes', 'product.offers'])
            ->latest()
            ->paginate($perPage);
    }
}
