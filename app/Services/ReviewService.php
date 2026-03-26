<?php

namespace App\Services;

use App\Models\DriverReview;
use App\Models\OrderReview;
use App\Models\ProductReview;
use Illuminate\Support\Facades\DB;

class ReviewService
{
    /**
     * Store a full review (Order, Products, and Driver).
     */
    public function storeReview(array $data)
    {
        return DB::transaction(function () use ($data) {
            // 1. Store Order Review
            $orderReview = OrderReview::create([
                'order_id' => $data['order_id'],
                'user_id' => auth()->id(),
                'rating' => $data['rating'],
                'comment' => $data['comment'] ?? null,
            ]);

            // 2. Store Product Reviews if present
            if (isset($data['product_reviews']) && is_array($data['product_reviews'])) {
                foreach ($data['product_reviews'] as $pReview) {
                    ProductReview::create([
                        'order_review_id' => $orderReview->id,
                        'user_id' => auth()->id(),
                        'product_id' => $pReview['product_id'],
                        'rating' => $pReview['rating'],
                        'comment' => $pReview['comment'] ?? null,
                    ]);
                }
            }

            // 3. Store Driver Review if present
            if (isset($data['driver_review'])) {
                DriverReview::create([
                    'order_review_id' => $orderReview->id,
                    'driver_id' => $data['driver_review']['driver_id'],
                    'rating' => $data['driver_review']['rating'],
                    'comment' => $data['driver_review']['comment'] ?? null,
                ]);
            }

            return $orderReview->load(['productReviews', 'driverReviews']);
        });
    }

    /**
     * Store an independent product review.
     */
    public function storeProductReview(array $data)
    {
        return ProductReview::create([
            'user_id' => auth()->id(),
            'product_id' => $data['product_id'],
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
        ]);
    }

    /**
     * Get product reviews.
     */
    public function getProductReviews($productId)
    {
        return ProductReview::with('user')
            ->where('product_id', $productId)
            ->latest()
            ->paginate(10);
    }

    /**
     * Update a product review.
     */
    public function updateProductReview($id, array $data)
    {
        $review = ProductReview::findOrFail($id);

        if ($review->user_id !== auth()->id()) {
            return [
                'status' => false,
                'message' => __('messages.unauthorized_review_action'),
            ];
        }

        $review->update([
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? $review->comment,
        ]);

        return [
            'status' => true,
            'message' => __('messages.review_updated_successfully'),
            'data' => $review,
        ];
    }

    /**
     * Delete a product review.
     */
    public function deleteProductReview($id)
    {
        $review = ProductReview::findOrFail($id);

        if ($review->user_id !== auth()->id()) {
            return [
                'status' => false,
                'message' => __('messages.unauthorized_review_action'),
            ];
        }

        $review->delete();

        return [
            'status' => true,
            'message' => __('messages.review_deleted_successfully'),
        ];
    }

    /**
     * Update an order review.
     */
    public function updateOrderReview($id, array $data)
    {
        $review = OrderReview::findOrFail($id);

        if ($review->user_id !== auth()->id()) {
            return [
                'status' => false,
                'message' => __('messages.unauthorized_review_action'),
            ];
        }

        $review->update([
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? $review->comment,
        ]);

        return [
            'status' => true,
            'message' => __('messages.review_updated_successfully'),
            'data' => $review,
        ];
    }

    /**
     * Delete an order review.
     */
    public function deleteOrderReview($id)
    {
        $review = OrderReview::findOrFail($id);

        if ($review->user_id !== auth()->id()) {
            return [
                'status' => false,
                'message' => __('messages.unauthorized_review_action'),
            ];
        }

        $review->delete(); // This will cascade delete related product_reviews and driver_reviews

        return [
            'status' => true,
            'message' => __('messages.review_deleted_successfully'),
        ];
    }

    /**
     * Get authenticated user's reviews.
     */
    public function getUserReviews()
    {
        return ProductReview::with(['product', 'user'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
    }
}
