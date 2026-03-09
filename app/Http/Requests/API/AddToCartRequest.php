<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->has('product_size_id') && empty($this->product_size_id)) {
            $this->merge(['product_size_id' => null]);
        }
    }

    public function rules(): array
    {
        return [
            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
                function ($attribute, $value, $fail) {
                    $product = \App\Models\Product::with('sizes')->find($value);
                    if (!$product)
                        return;

                    $hasSizes = $product->sizes->isNotEmpty();
                    $hasNoPrice = empty($product->price) || $product->price <= 0;
                    $sizeId = $this->input('product_size_id');

                    // لو المنتج ملوش سعر (0 أو null) أو ليه أحجام -> يبقا لازم يختار حجم
                    if (($hasNoPrice || $hasSizes) && empty($sizeId)) {
                        $fail(__('messages.size_required_for_this_product'));
                    }

                    // لو ملوش أحجام أصلاً -> ممنوع يبعت حجم
                    if (!$hasSizes && !empty($sizeId)) {
                        $fail(__('messages.product_does_not_have_sizes'));
                    }
                },
            ],
            'product_size_id' => 'nullable|exists:product_sizes,id',
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
            'product_size_id.exists' => __('messages.size_not_found_for_product'),
            'quantity.required' => __('messages.quantity_required'),
            'quantity.min' => __('messages.quantity_min'),
        ];
    }
}
