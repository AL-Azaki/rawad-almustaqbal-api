<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authentication is handled by middleware
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:projects,slug'],
            'category' => ['required', 'string', 'max:255'],
            'location_district' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:3000'],
            'text' => ['nullable', 'string', 'max:3000'],
            'challenge_solution_text' => ['nullable', 'string'],
            'duration' => ['nullable', 'string', 'max:255'],
            'installed_equipment' => ['nullable', 'array'],
            'video_url' => ['nullable', 'string', 'max:255'],
            'video_path' => ['nullable', 'string', 'max:255'],
            'video' => ['nullable', 'file', 'mimes:mp4,mov,webm', 'max:102400'],
            'before_image_path' => ['nullable', 'string', 'max:255'],
            'after_image_path' => ['nullable', 'string', 'max:255'],
            'before_image' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:102400'],
            'after_image' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:102400'],
            'image' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,svg,mp4,webm', 'max:102400'],
            'image_url' => ['nullable', 'string', 'url'],
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
