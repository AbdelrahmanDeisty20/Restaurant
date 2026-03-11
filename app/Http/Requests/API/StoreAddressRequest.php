<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'address' => 'required|string',
            'is_default' => 'nullable|boolean',
        ];
    }
}
