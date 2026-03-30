<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'delivery_address' => 'required|string',
            'delivery_lat' => 'nullable|numeric',
            'delivery_lng' => 'nullable|numeric',
            'payment_method' => 'nullable|string|in:cash,card',
            'governorate_id' => 'required|exists:governorates,id',
            'notes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required' => __('messages.customer_name_required'),
            'customer_phone.required' => __('messages.customer_phone_required'),
            'delivery_address.required' => __('messages.delivery_address_required'),
            'governorate_id.required' => __('messages.governorate_required'),
            'governorate_id.exists' => __('messages.governorate_exists'),
        ];
    }
}
