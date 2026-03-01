<?php

namespace App\Http\Requests\API\AUTH;

use Illuminate\Foundation\Http\FormRequest;

class EmailVerifiedRequest extends FormRequest
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
            'email' => 'required|email',
            'code' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => __('messages.email_required'),
            'email.email' => __('messages.email_invalid'),
            'code.required' => __('messages.code_required'),
            'code.numeric' => __('messages.code_numeric'),
        ];
    }
}
