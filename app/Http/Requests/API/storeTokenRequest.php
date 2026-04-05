<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class storeTokenRequest extends FormRequest
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
            'fcm_token' => 'required|string',
            'device_id' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'fcm_token.required' => 'FCM Token is required',
            'fcm_token.string' => 'FCM Token must be a string',
            'device_id.string' => 'Device ID must be a string',
            'user_id.exists' => 'User ID must exist',
        ];
    }
}
