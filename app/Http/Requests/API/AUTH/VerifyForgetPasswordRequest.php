<?php

namespace App\Http\Requests\API\AUTH;

use Illuminate\Foundation\Http\FormRequest;

class VerifyForgetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => __('messages.email_required'),
            'email.email' => __('messages.email_invalid'),
            'email.exists' => __('messages.user_not_found'),
            'otp.required' => __('messages.code_required'),
            'otp.numeric' => __('messages.code_numeric'),
        ];
    }
}
