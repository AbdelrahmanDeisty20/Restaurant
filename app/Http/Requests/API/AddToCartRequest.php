<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|integer|exists:products,id',
            'product_size_id' => 'nullable|integer|exists:product_sizes,id',
            'quantity' => 'required|integer|min:1',
            'extras' => 'nullable|array',
            'extras.*' => 'integer|exists:product_extras,id',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => __('messages.product_id_required'),
            'product_id.exists' => __('messages.product_not_found'),
            'quantity.required' => __('messages.quantity_required'),
            'quantity.min' => __('messages.quantity_min'),
        ];
    }
}
