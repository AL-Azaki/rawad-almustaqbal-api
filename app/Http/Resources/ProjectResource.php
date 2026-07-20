<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $mediaService = app(\App\Services\MediaService::class);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug ?? (string) $this->id,
            'category' => $this->category,
            'location_district' => $this->location_district,
            'description' => $this->description,
            'challenge_solution_text' => $this->challenge_solution_text,
            'duration' => $this->duration,
            'installed_equipment' => $this->installed_equipment ?? [],
            'image_path' => $mediaService->getPublicUrl($this->image_path),
            'raw_image_path' => $this->image_path,
            'video_path' => $mediaService->getPublicUrl($this->video_path),
            'raw_video_path' => $this->video_path,
            'video_url' => $this->video_url ? (filter_var($this->video_url, FILTER_VALIDATE_URL) ? $this->video_url : $mediaService->getPublicUrl($this->video_url)) : null,
            'before_image_path' => $mediaService->getPublicUrl($this->before_image_path),
            'raw_before_image_path' => $this->before_image_path,
            'after_image_path' => $mediaService->getPublicUrl($this->after_image_path),
            'raw_after_image_path' => $this->after_image_path,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
