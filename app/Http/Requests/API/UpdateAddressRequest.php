<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'address' => 'sometimes|required|string',
            'is_default' => 'nullable|boolean',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => __('messages.address_title_required'),
            'address.required' => __('messages.address_required'),
        ];
    }
}
