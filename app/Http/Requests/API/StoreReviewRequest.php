<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
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
}
