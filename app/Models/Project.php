<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'location_district',
        'image_path',
        'description',
        'challenge_solution_text',
        'duration',
        'installed_equipment',
        'video_url',
        'video_path',
        'before_image_path',
        'after_image_path'
    ];

    protected $casts = [
        'installed_equipment' => 'array',
        'completion_date' => 'date',
    ];
}
