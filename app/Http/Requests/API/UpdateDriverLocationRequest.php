<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDriverLocationRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'driver_id' => 'required|exists:drivers,id',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ];
    }

    /**
     * Get customized error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'driver_id.required' => __('messages.driver_id_required'),
            'driver_id.exists' => __('messages.driver_not_found'),
            'lat.required' => __('messages.lat_required'),
            'lat.numeric' => __('messages.lat_numeric'),
            'lng.required' => __('messages.lng_required'),
            'lng.numeric' => __('messages.lng_numeric'),
        ];
    }
}
