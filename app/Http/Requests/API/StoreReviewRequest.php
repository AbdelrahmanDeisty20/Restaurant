<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $raw = $this->all();

        // 1. Process Driver Review
        // Check for dot notation OR underscore notation (common in PHP form-data)
        if (!isset($raw['driver_review'])) {
            $driverId = $raw['driver_review.driver_id'] ?? $raw['driver_review_driver_id'] ?? null;
            $rating = $raw['driver_review.rating'] ?? $raw['driver_review_rating'] ?? null;
            $comment = $raw['driver_review.comment'] ?? $raw['driver_review_comment'] ?? null;

            if ($driverId) {
                $this->merge([
                    'driver_review' => [
                        'driver_id' => $driverId,
                        'rating'    => $rating,
                        'comment'   => $comment,
                    ],
                ]);
            }
        }

        // 2. Process Product Reviews
        if (!isset($raw['product_reviews'])) {
            $productReviews = [];
            $i = 0;
            // Check for dot notation (product_reviews.0.product_id) OR underscore notation (product_reviews_0_product_id)
            while (isset($raw["product_reviews.$i.product_id"]) || isset($raw["product_reviews_{$i}_product_id"])) {
                $productReviews[] = [
                    'product_id' => $raw["product_reviews.$i.product_id"] ?? $raw["product_reviews_{$i}_product_id"],
                    'rating'     => $raw["product_reviews.$i.rating"] ?? $raw["product_reviews_{$i}_rating"] ?? null,
                    'comment'    => $raw["product_reviews.$i.comment"] ?? $raw["product_reviews_{$i}_comment"] ?? null,
                ];
                $i++;
            }
            if (!empty($productReviews)) {
                $this->merge(['product_reviews' => $productReviews]);
            }
        }
    }

    public function rules(): array
    {
        return [
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
            'product_reviews' => 'nullable|array',
            'product_reviews.*.product_id' => 'required|exists:products,id',
            'product_reviews.*.rating' => 'required|integer|min:1|max:5',
            'product_reviews.*.comment' => 'nullable|string',
            'driver_review' => 'nullable|array',
            'driver_review.driver_id' => 'required|exists:drivers,id',
            'driver_review.rating' => 'required|integer|min:1|max:5',
            'driver_review.comment' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'order_id.required' => __('messages.order_id_required'),
            'order_id.exists' => __('messages.order_not_found'),
            'rating.required' => __('messages.rating_required'),
            'rating.min' => __('messages.rating_min'),
            'rating.max' => __('messages.rating_max'),
            'product_reviews.*.product_id.required' => __('messages.product_id_required'),
            'product_reviews.*.product_id.exists' => __('messages.product_not_found'),
            'product_reviews.*.rating.required' => __('messages.rating_required'),
            'product_reviews.*.rating.min' => __('messages.rating_min'),
            'product_reviews.*.rating.max' => __('messages.rating_max'),
            'driver_review.driver_id.required' => __('messages.driver_id_required'),
            'driver_review.driver_id.exists' => __('messages.driver_not_found'),
            'driver_review.rating.required' => __('messages.rating_required'),
            'driver_review.rating.min' => __('messages.rating_min'),
            'driver_review.rating.max' => __('messages.rating_max'),
        ];
    }
}
