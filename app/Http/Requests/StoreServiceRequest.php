<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:3000'],
            'text' => ['nullable', 'string', 'max:3000'],
            'icon' => ['nullable', 'string'],
            'starting_price' => ['nullable', 'numeric', 'min:0'],
            'status' => ['nullable', 'string', 'in:active,inactive'],
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
