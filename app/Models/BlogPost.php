<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'slug',
        'title_ar',
        'title_en',
        'excerpt_ar',
        'excerpt_en',
        'content_ar',
        'content_en',
        'category_ar',
        'category_en',
        'image_path',
        'reading_time',
        'related_service_slug',
        'author_name',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'reading_time' => 'integer',
    ];

    /**
     * Scope a query to only include published posts.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Accessor to ensure image_path always returns a valid absolute or Cloudinary URL.
     */
    public function getImagePathAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        return app(\App\Services\MediaService::class)->getPublicUrl($value);
    }
}
