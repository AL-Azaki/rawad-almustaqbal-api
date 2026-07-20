<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (!Schema::hasColumn('projects', 'video_path')) {
                $table->string('video_path')->nullable()->after('video_url');
            }
        });

        // Data cleanup and normalization:
        // Move local storage paths in video_url into video_path, and strip any leading 'storage/' or '/storage/' from paths
        $projects = DB::table('projects')->get();
        foreach ($projects as $project) {
            $update = [];

            // Clean image_path
            if (!empty($project->image_path)) {
                $cleanImage = preg_replace('#^/?storage/#', '', $project->image_path);
                if ($cleanImage !== $project->image_path) {
                    $update['image_path'] = $cleanImage;
                }
            }

            // Clean before_image_path
            if (!empty($project->before_image_path)) {
                $cleanBefore = preg_replace('#^/?storage/#', '', $project->before_image_path);
                if ($cleanBefore !== $project->before_image_path) {
                    $update['before_image_path'] = $cleanBefore;
                }
            }

            // Clean after_image_path
            if (!empty($project->after_image_path)) {
                $cleanAfter = preg_replace('#^/?storage/#', '', $project->after_image_path);
                if ($cleanAfter !== $project->after_image_path) {
                    $update['after_image_path'] = $cleanAfter;
                }
            }

            // Separate video_url into video_path (if local file) vs video_url (if external URL)
            if (!empty($project->video_url)) {
                $val = $project->video_url;
                $isLocalOrFile = str_starts_with($val, '/storage/') ||
                                 str_starts_with($val, 'storage/') ||
                                 str_starts_with($val, 'projects/') ||
                                 preg_match('/\.(mp4|mov|webm)$/i', $val);
                
                // If it's not a clear external HTTP/HTTPS video portal URL like youtube/vimeo/external link
                if ($isLocalOrFile && !str_contains($val, 'youtube.com') && !str_contains($val, 'youtu.be') && !str_contains($val, 'vimeo.com')) {
                    $cleanVideo = preg_replace('#^/?storage/#', '', $val);
                    $update['video_path'] = $cleanVideo;
                    $update['video_url'] = null;
                }
            }

            if (!empty($update)) {
                DB::table('projects')->where('id', $project->id)->update($update);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (Schema::hasColumn('projects', 'video_path')) {
                $table->dropColumn('video_path');
            }
        });
    }
};
