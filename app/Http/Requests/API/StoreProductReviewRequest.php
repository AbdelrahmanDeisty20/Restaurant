<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => __('messages.product_id_required'),
            'product_id.exists' => __('messages.product_not_found'),
            'rating.required' => __('messages.rating_required'),
            'rating.min' => __('messages.rating_min'),
            'rating.max' => __('messages.rating_max'),
            'comment.required' => __('messages.comment_required'),
        ];
    }
}
