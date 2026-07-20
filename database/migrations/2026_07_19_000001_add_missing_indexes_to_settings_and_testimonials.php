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
        Schema::table('testimonials', function (Blueprint $table) {
            $table->index('is_approved');
        });

        // Note: settings(key) is already unique indexed in 2026_06_07_073545_create_settings_table.php
        // Avoided duplicating unique('key') index to comply with Single Source of Truth rules.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropIndex(['is_approved']);
        });
    }
};
