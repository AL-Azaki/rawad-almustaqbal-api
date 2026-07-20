<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (!Schema::hasColumn('projects', 'slug')) {
                $table->string('slug')->nullable()->unique()->after('title');
            }
            if (!Schema::hasColumn('projects', 'location_district')) {
                $table->string('location_district')->nullable()->after('category');
            }
            if (!Schema::hasColumn('projects', 'challenge_solution_text')) {
                $table->longText('challenge_solution_text')->nullable()->after('description');
            }
            if (!Schema::hasColumn('projects', 'duration')) {
                $table->string('duration')->nullable()->after('challenge_solution_text');
            }
            if (!Schema::hasColumn('projects', 'installed_equipment')) {
                $table->json('installed_equipment')->nullable()->after('duration');
            }
            if (!Schema::hasColumn('projects', 'video_url')) {
                $table->string('video_url')->nullable()->after('installed_equipment');
            }
            if (!Schema::hasColumn('projects', 'before_image_path')) {
                $table->string('before_image_path')->nullable()->after('video_url');
            }
            if (!Schema::hasColumn('projects', 'after_image_path')) {
                $table->string('after_image_path')->nullable()->after('before_image_path');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'slug',
                'location_district',
                'challenge_solution_text',
                'duration',
                'installed_equipment',
                'video_url',
                'before_image_path',
                'after_image_path'
            ]);
        });
    }
};
