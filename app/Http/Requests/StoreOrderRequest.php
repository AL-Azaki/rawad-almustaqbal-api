<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Public access
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'location' => ['required', 'string', 'max:255'],
            'service_id' => ['required', 'exists:services,id'],
            'description' => ['required', 'string', 'max:3000'],
            'text' => ['nullable', 'string', 'max:3000'],
        ];
    }

    public function messages(): array
    {
        return [
            'description.max' => 'تفاصيل الطلب يجب ألا تتجاوز 3000 حرف',
            'text.max' => 'تفاصيل الطلب يجب ألا تتجاوز 3000 حرف',
        ];
    }
}
