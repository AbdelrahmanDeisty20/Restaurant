<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class FilterProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'nullable|exists:categories,id',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'most_sold' => 'nullable|boolean',
            'new_arrivals' => 'nullable|boolean',
            'special_offers' => 'nullable|boolean',
            'ratings' => 'nullable|integer|min:1|max:5',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.exists' => __('messages.category_not_found'),
            'ratings.integer' => __('messages.rating_invalid'),
            'ratings.min' => __('messages.rating_min'),
            'ratings.max' => __('messages.rating_max'),
        ];
    }
}
