<?php

namespace App\Services;

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    private bool $useCloudinary;

    public function __construct()
    {
        $this->useCloudinary = config('features.cloudinary', false);

        if ($this->useCloudinary) {
            Configuration::instance([
                'cloud' => [
                    'cloud_name' => config('services.cloudinary.cloud_name'),
                    'api_key' => config('services.cloudinary.api_key'),
                    'api_secret' => config('services.cloudinary.api_secret'),
                ],
                'url' => ['secure' => true]
            ]);
        }
    }

    /**
     * Upload an image file and return its URL.
     */
    public function uploadImage(UploadedFile $file, string $folder): string
    {
        if ($this->useCloudinary) {
            try {
                $upload = (new UploadApi())->upload($file->getRealPath(), [
                    'folder' => $folder,
                    'resource_type' => 'auto'
                ]);
                
                return $upload['secure_url'];
            } catch (\Exception $e) {
                Log::error('MediaService Upload Error: ' . $e->getMessage());
            }
        }

        // Local Storage
        $path = $file->store($folder, 'public');
        return $path;
    }

    /**
     * Delete an image or media by its path or URL.
     */
    public function deleteImage(?string $url): void
    {
        if (!$url) return;

        // If it is an external URL that is not on our local server
        if (filter_var($url, FILTER_VALIDATE_URL) && !str_contains($url, '/storage/')) {
            if ($this->useCloudinary) {
                try {
                    Log::info("Cloudinary: Requested deletion for: {$url}");
                } catch (\Exception $e) {
                    Log::error('MediaService Delete Error: ' . $e->getMessage());
                }
            }
            return;
        }

        // Local physical file deletion
        $cleanPath = $this->normalizeStoragePath($url);
        if ($cleanPath && Storage::disk('public')->exists($cleanPath)) {
            Storage::disk('public')->delete($cleanPath);
            Log::info("Local Storage: Physically deleted file at: {$cleanPath}");
        }
    }

    /**
     * Upload any media file (image, video, etc.) and return its relative storage path or URL.
     */
    public function uploadMedia(UploadedFile $file, string $folder): string
    {
        return $this->uploadImage($file, $folder);
    }

    /**
     * Delete any media by its URL or storage path.
     */
    public function deleteMedia(?string $url): void
    {
        $this->deleteImage($url);
    }

    /**
     * Strip any leading /storage/ or absolute local URL parts to get the relative public disk path.
     */
    public function normalizeStoragePath(?string $path): ?string
    {
        if (empty($path)) return null;

        // If it's an external HTTP/HTTPS URL not pointing to our local storage
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            if (!str_contains($path, '/storage/')) {
                return $path;
            }
            // If it contains /storage/, extract the part after /storage/
            $parts = explode('/storage/', $path);
            return ltrim(end($parts), '/');
        }

        // Strip leading storage/ or /storage/
        return preg_replace('#^/?storage/#', '', ltrim($path, '/'));
    }

    /**
     * Return a fully formed, valid public absolute URL or external URL.
     */
    public function getPublicUrl(?string $path): ?string
    {
        if (empty($path)) return null;

        if (filter_var($path, FILTER_VALIDATE_URL) && !str_contains($path, '/storage/')) {
            return $path;
        }

        $cleanPath = $this->normalizeStoragePath($path);
        if (!$cleanPath) return null;

        $url = Storage::disk('public')->url($cleanPath);
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return asset(ltrim($url, '/'));
        }

        return $url;
    }
}
