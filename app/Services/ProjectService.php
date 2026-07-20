<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectService
{
    public function __construct(private MediaService $mediaService)
    {
    }

    public function createProject(array $data, ?UploadedFile $imageFile, ?UploadedFile $beforeImageFile = null, ?UploadedFile $afterImageFile = null, ?UploadedFile $videoFile = null): Project
    {
        $imagePath = $this->resolveImagePath($data, $imageFile);
        $beforeImagePath = $beforeImageFile ? $this->mediaService->uploadMedia($beforeImageFile, 'projects') : $this->mediaService->normalizeStoragePath($data['before_image_path'] ?? null);
        $afterImagePath = $afterImageFile ? $this->mediaService->uploadMedia($afterImageFile, 'projects') : $this->mediaService->normalizeStoragePath($data['after_image_path'] ?? null);
        $videoPath = $videoFile ? $this->mediaService->uploadMedia($videoFile, 'projects/videos') : $this->mediaService->normalizeStoragePath($data['video_path'] ?? null);
        $videoUrl = !empty($data['video_url']) ? trim($data['video_url']) : null;
        $slug = $this->generateUniqueSlug($data['slug'] ?? null, $data['title'] ?? '');

        return Project::create([
            'title' => $data['title'],
            'slug' => $slug,
            'category' => $data['category'],
            'location_district' => $data['location_district'] ?? null,
            'description' => $data['description'],
            'challenge_solution_text' => $data['challenge_solution_text'] ?? null,
            'duration' => $data['duration'] ?? null,
            'installed_equipment' => $data['installed_equipment'] ?? null,
            'video_url' => $videoUrl,
            'video_path' => $videoPath,
            'before_image_path' => $beforeImagePath,
            'after_image_path' => $afterImagePath,
            'image_path' => $imagePath,
        ]);
    }

    public function updateProject(Project $project, array $data, ?UploadedFile $imageFile, ?UploadedFile $beforeImageFile = null, ?UploadedFile $afterImageFile = null, ?UploadedFile $videoFile = null): Project
    {
        $oldImagePath = $project->image_path;
        $oldBeforeImagePath = $project->before_image_path;
        $oldAfterImagePath = $project->after_image_path;
        $oldVideoPath = $project->video_path;

        // 1. Cover Image
        if ($imageFile) {
            $newImagePath = $this->mediaService->uploadImage($imageFile, 'projects');
        } elseif (array_key_exists('image_url', $data) || array_key_exists('image_path', $data)) {
            $val = $data['image_url'] ?? $data['image_path'] ?? null;
            $newImagePath = $this->mediaService->normalizeStoragePath($val);
        } else {
            $newImagePath = $oldImagePath;
        }

        // 2. Before Image
        if ($beforeImageFile) {
            $beforeImagePath = $this->mediaService->uploadMedia($beforeImageFile, 'projects');
        } elseif (array_key_exists('before_image_path', $data)) {
            $beforeImagePath = $this->mediaService->normalizeStoragePath($data['before_image_path']);
        } else {
            $beforeImagePath = $oldBeforeImagePath;
        }

        // 3. After Image
        if ($afterImageFile) {
            $afterImagePath = $this->mediaService->uploadMedia($afterImageFile, 'projects');
        } elseif (array_key_exists('after_image_path', $data)) {
            $afterImagePath = $this->mediaService->normalizeStoragePath($data['after_image_path']);
        } else {
            $afterImagePath = $oldAfterImagePath;
        }

        // 4. Local Video File
        if ($videoFile) {
            $videoPath = $this->mediaService->uploadMedia($videoFile, 'projects/videos');
        } elseif (array_key_exists('video_path', $data)) {
            $videoPath = $this->mediaService->normalizeStoragePath($data['video_path']);
        } else {
            $videoPath = $oldVideoPath;
        }

        // 5. External Video URL
        if (array_key_exists('video_url', $data)) {
            $videoUrl = !empty($data['video_url']) ? trim($data['video_url']) : null;
        } else {
            $videoUrl = $project->video_url;
        }

        $slug = !empty($data['slug']) ? Str::slug($data['slug']) : ($project->slug ?: $this->generateUniqueSlug(null, $data['title'] ?? $project->title, $project->id));

        $project->update([
            'title' => $data['title'],
            'slug' => $slug,
            'category' => $data['category'],
            'location_district' => $data['location_district'] ?? $project->location_district,
            'description' => $data['description'],
            'challenge_solution_text' => $data['challenge_solution_text'] ?? $project->challenge_solution_text,
            'duration' => $data['duration'] ?? $project->duration,
            'installed_equipment' => array_key_exists('installed_equipment', $data) ? $data['installed_equipment'] : $project->installed_equipment,
            'video_url' => $videoUrl,
            'video_path' => $videoPath,
            'before_image_path' => $beforeImagePath,
            'after_image_path' => $afterImagePath,
            'image_path' => $newImagePath,
        ]);

        if ($oldImagePath && $oldImagePath !== $newImagePath) {
            $this->mediaService->deleteMedia($oldImagePath);
        }
        if ($oldBeforeImagePath && $oldBeforeImagePath !== $beforeImagePath) {
            $this->mediaService->deleteMedia($oldBeforeImagePath);
        }
        if ($oldAfterImagePath && $oldAfterImagePath !== $afterImagePath) {
            $this->mediaService->deleteMedia($oldAfterImagePath);
        }
        if ($oldVideoPath && $oldVideoPath !== $videoPath) {
            $this->mediaService->deleteMedia($oldVideoPath);
        }

        return $project;
    }

    private function generateUniqueSlug(?string $customSlug, string $title, ?int $ignoreId = null): string
    {
        $slug = !empty($customSlug) ? Str::slug($customSlug) : Str::slug($title);
        if (empty($slug)) {
            $slug = 'project-' . time();
        }
        $originalSlug = $slug;
        $counter = 1;

        while (Project::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function deleteProject(Project $project): void
    {
        if ($project->image_path) {
            $this->mediaService->deleteMedia($project->image_path);
        }
        if ($project->before_image_path) {
            $this->mediaService->deleteMedia($project->before_image_path);
        }
        if ($project->after_image_path) {
            $this->mediaService->deleteMedia($project->after_image_path);
        }
        if ($project->video_path) {
            $this->mediaService->deleteMedia($project->video_path);
        }
        if ($project->video_url && !filter_var($project->video_url, FILTER_VALIDATE_URL)) {
            $this->mediaService->deleteMedia($project->video_url);
        }
        
        $project->delete();
    }

    private function resolveImagePath(array $data, ?UploadedFile $imageFile): ?string
    {
        if ($imageFile) {
            return $this->mediaService->uploadImage($imageFile, 'projects');
        }

        return $this->mediaService->normalizeStoragePath($data['image_url'] ?? $data['image_path'] ?? null);
    }
}
