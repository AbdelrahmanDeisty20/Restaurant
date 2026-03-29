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
        // Handle driver_review flat keys (e.g. driver_review.driver_id from form-data)
        if ($this->has('driver_review.driver_id') && !$this->has('driver_review')) {
            $this->merge([
                'driver_review' => [
                    'driver_id' => $this->input('driver_review.driver_id'),
                    'rating' => $this->input('driver_review.rating'),
                    'comment' => $this->input('driver_review.comment'),
                ],
            ]);
        }

        // Handle product_reviews flat keys if needed
        // (This is more complex for multiple items, but we can support simple case if user sends it)
        if (!$this->has('product_reviews') && $this->anyFilled(['product_reviews.0.product_id'])) {
            $productReviews = [];
            $i = 0;
            while ($this->has("product_reviews.$i.product_id")) {
                $productReviews[] = [
                    'product_id' => $this->input("product_reviews.$i.product_id"),
                    'rating' => $this->input("product_reviews.$i.rating"),
                    'comment' => $this->input("product_reviews.$i.comment"),
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
