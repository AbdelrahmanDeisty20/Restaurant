<?php

namespace App\Http\Requests\API\AUTH;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => ['required', 'string', 'regex:/^01[0125][0-9]{8}$/'],
            'avatar' => 'required|image',
        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => __('messages.full_name_required'),
            'email.required' => __('messages.email_required'),
            'email.email' => __('messages.email_invalid'),
            'email.unique' => __('messages.email_unique'),
            'password.required' => __('messages.password_required'),
            'password.min' => __('messages.password_min'),
            'password.confirmed' => __('messages.password_confirmed'),
            'phone.required' => __('messages.phone_required'),
            'phone.regex' => __('messages.phone_invalid'),
            'avatar.required' => __('messages.avatar_required'),
            'avatar.image' => __('messages.avatar_image'),
            'password_confirmation.required' => __('messages.password_confirmation_required'),
            'password_confirmation.min' => __('messages.password_confirmation_min'),
            'password_confirmation.same' => __('messages.password_confirmation_same'),
        ];
    }
}
