<?php

namespace App\Services;

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class MediaService
{
    private bool $useCloudinary;

    public function __construct()
    {
        $this->useCloudinary = config('features.cloudinary', false);

        if ($this->useCloudinary) {
            $cloudinaryUrl = config('services.cloudinary.url') ?: env('CLOUDINARY_URL');
            if (!empty($cloudinaryUrl)) {
                Configuration::instance($cloudinaryUrl);
            } else {
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
    }

    /**
     * Upload an image file and return its URL or relative storage path.
     */
    public function uploadImage(UploadedFile $file, string $folder): string
    {
        return $this->uploadMedia($file, $folder);
    }

    /**
     * Upload any media file (image, video, etc.) and return its URL or relative storage path.
     */
    public function uploadMedia(UploadedFile $file, string $folder): string
    {
        $metadata = $this->uploadWithMetadata($file, $folder);
        return $metadata['secure_url'];
    }

    /**
     * Upload media file and return full metadata array.
     * Preserves single-source-of-truth in Cloudinary when enabled.
     */
    public function uploadWithMetadata(UploadedFile $file, string $folder): array
    {
        if (!$file->isValid()) {
            throw new RuntimeException("Attempted to upload an invalid or corrupted file.");
        }

        $folder = ltrim($folder, '/');

        if ($this->useCloudinary) {
            try {
                // Determine resource type based on mime or folder
                $mime = $file->getMimeType() ?: '';
                $resourceType = str_starts_with($mime, 'video/') || str_contains($folder, 'videos') ? 'video' : 'auto';

                $upload = (new UploadApi())->upload($file->getRealPath());

                return [
                    'secure_url' => $upload['secure_url'] ?? '',
                    'public_id' => $upload['public_id'] ?? '',
                    'resource_type' => $upload['resource_type'] ?? 'image',
                    'format' => $upload['format'] ?? '',
                    'bytes' => $upload['bytes'] ?? 0,
                    'width' => $upload['width'] ?? null,
                    'height' => $upload['height'] ?? null,
                    'duration' => $upload['duration'] ?? null,
                ];
            } catch (\Exception $e) {
                Log::error('MediaService Cloudinary Upload Error: ' . $e->getMessage());
                // In production with Cloudinary enabled, never fall back to ephemeral disk
                if (config('app.env') === 'production') {
                    throw new RuntimeException("Cloudinary upload failed: " . $e->getMessage(), 0, $e);
                }
            }
        }

        // Local Storage fallback (Development / Non-Cloudinary environments)
        $path = $file->store($folder, 'public');
        $fullUrl = Storage::disk('public')->url($path);

        return [
            'secure_url' => $path,
            'public_id' => $path,
            'resource_type' => str_starts_with($file->getMimeType() ?: '', 'video/') ? 'video' : 'image',
            'format' => $file->getClientOriginalExtension(),
            'bytes' => $file->getSize(),
            'width' => null,
            'height' => null,
            'duration' => null,
            'local_url' => $fullUrl,
        ];
    }

    /**
     * Delete an image or media by its path or URL from Cloudinary or local storage.
     */
    public function deleteImage(?string $url): void
    {
        $this->deleteMedia($url);
    }

    /**
     * Delete any media by its URL or storage path.
     */
    public function deleteMedia(?string $url): void
    {
        if (empty($url)) {
            return;
        }

        // Check if it is a Cloudinary URL
        if (str_contains($url, 'cloudinary.com') || str_contains($url, 'res.cloudinary.com')) {
            if ($this->useCloudinary) {
                try {
                    $info = $this->extractCloudinaryPublicIdAndResourceType($url);
                    if (!empty($info['public_id'])) {
                        (new UploadApi())->destroy($info['public_id'], [
                            'resource_type' => $info['resource_type'],
                            'invalidate' => true,
                        ]);
                        Log::info("Cloudinary: Successfully deleted asset: {$info['public_id']} ({$info['resource_type']})");
                    }
                } catch (\Exception $e) {
                    Log::error("MediaService Cloudinary Delete Error for {$url}: " . $e->getMessage());
                }
            }
            return;
        }

        // If external URL outside Cloudinary and not on local storage, do not attempt physical deletion
        if (filter_var($url, FILTER_VALIDATE_URL) && !str_contains($url, '/storage/')) {
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
     * Extract Cloudinary public_id and resource_type from a secure_url.
     */
    public function extractCloudinaryPublicIdAndResourceType(string $url): array
    {
        $parsed = parse_url($url, PHP_URL_PATH);
        if (!$parsed) {
            return ['public_id' => null, 'resource_type' => 'image'];
        }

        // Determine resource_type from URL structure (/image/upload/ or /video/upload/ or /raw/upload/)
        $resourceType = 'image';
        if (str_contains($parsed, '/video/upload/')) {
            $resourceType = 'video';
        } elseif (str_contains($parsed, '/raw/upload/')) {
            $resourceType = 'raw';
        }

        // Extract the portion after /upload/
        $parts = explode('/upload/', $parsed);
        if (count($parts) < 2) {
            return ['public_id' => null, 'resource_type' => $resourceType];
        }

        $afterUpload = $parts[1]; // e.g. v1234567890/projects/sample.jpg or projects/sample.jpg
        $pathSegments = explode('/', ltrim($afterUpload, '/'));

        // If the first segment starts with 'v' followed by digits (version), remove it
        if (!empty($pathSegments[0]) && preg_match('/^v\d+$/', $pathSegments[0])) {
            array_shift($pathSegments);
        }

        $relativePath = implode('/', $pathSegments);
        if (empty($relativePath)) {
            return ['public_id' => null, 'resource_type' => $resourceType];
        }

        // For image and video, Cloudinary destroy API expects public_id without file extension
        if (in_array($resourceType, ['image', 'video'], true)) {
            $lastDot = strrpos($relativePath, '.');
            if ($lastDot !== false) {
                $relativePath = substr($relativePath, 0, $lastDot);
            }
        }

        return [
            'public_id' => $relativePath,
            'resource_type' => $resourceType,
        ];
    }

    /**
     * Strip any leading /storage/ or absolute local URL parts to get the relative public disk path.
     */
    public function normalizeStoragePath(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        // If it's an external HTTP/HTTPS URL (including Cloudinary) not pointing to our local storage
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            if (!str_contains($path, '/storage/')) {
                return $path;
            }
            $parts = explode('/storage/', $path);
            return ltrim(end($parts), '/');
        }

        return preg_replace('#^/?storage/#', '', ltrim($path, '/'));
    }

    /**
     * Return a fully formed, valid public absolute URL or external Cloudinary URL.
     */
    public function getPublicUrl(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL) && !str_contains($path, '/storage/')) {
            return $path;
        }

        $cleanPath = $this->normalizeStoragePath($path);
        if (!$cleanPath) {
            return null;
        }

        $url = Storage::disk('public')->url($cleanPath);
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return asset(ltrim($url, '/'));
        }

        return $url;
    }
}
