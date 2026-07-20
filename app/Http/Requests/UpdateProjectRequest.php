<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $projectId = $this->route('id') ?? ($this->route('project') ? $this->route('project')->id : null);

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('projects', 'slug')->ignore($projectId)],
            'category' => ['required', 'string', 'max:255'],
            'location_district' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
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
}
