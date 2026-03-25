<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20|regex:/^01[0125][0-9]{8}$/',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('messages.contact_name_required'),
            'email.required' => __('messages.email_required'),
            'email.email' => __('messages.email_invalid'),
            'phone.required' => __('messages.phone_required'),
            'phone.regex' => __('messages.phone_invalid'),
            'subject.required' => __('messages.contact_subject_required'),
            'message.required' => __('messages.contact_message_required'),
        ];
    }
}
