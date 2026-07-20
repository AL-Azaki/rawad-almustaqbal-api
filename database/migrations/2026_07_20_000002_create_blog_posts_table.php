<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('blog_posts')) {
            Schema::create('blog_posts', function (Blueprint $table) {
                $table->id();
                $table->string('slug')->unique();
                $table->string('title_ar');
                $table->string('title_en')->nullable();
                $table->text('excerpt_ar')->nullable();
                $table->text('excerpt_en')->nullable();
                $table->longText('content_ar');
                $table->longText('content_en')->nullable();
                $table->string('category_ar')->default('نصائح هندسية');
                $table->string('category_en')->default('Engineering Tips');
                $table->string('image_path')->nullable();
                $table->integer('reading_time')->default(5); // in minutes
                $table->string('related_service_slug')->nullable(); // e.g. electrical-services-jeddah
                $table->string('author_name')->default('مهندسو رواد المستقبل');
                $table->string('status')->default('published'); // published, draft
                $table->timestamp('published_at')->nullable();
                $table->timestamps();
                $table->softDeletes();

                // Indexes for fast searching and filtering
                $table->index('status');
                $table->index('category_ar');
                $table->index('published_at');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
