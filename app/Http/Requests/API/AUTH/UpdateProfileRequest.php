<?php

namespace App\Http\Requests\API\AUTH;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'full_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }
    public function messages()
    {
        return [
            'full_name.required' => __('messages.full_name_required'),
            'phone.required' => __('messages.phone_required'),
            'avatar.required' => __('messages.avatar_required'),
            'password.required' => __('messages.password_required'),
            'password.confirmed' => __('messages.password_confirmed'),
            'password.min' => __('messages.password_min'),
        ];
    }
}
