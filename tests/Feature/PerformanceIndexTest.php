<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Testimonial;
use Tests\TestCase;

class PerformanceIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_testimonials_table_has_is_approved_index(): void
    {
        $indexes = Schema::getIndexes('testimonials');
        $indexNames = array_column($indexes, 'name');

        $this->assertTrue(
            in_array('testimonials_is_approved_index', $indexNames),
            'Index testimonials_is_approved_index not found on testimonials table!'
        );
    }

    public function test_settings_table_has_key_index_or_unique_constraint(): void
    {
        $indexes = Schema::getIndexes('settings');
        $indexNames = array_column($indexes, 'name');

        $this->assertTrue(
            in_array('settings_key_unique', $indexNames) || in_array('settings_key_index', $indexNames),
            'Unique or standard index on settings(key) not found!'
        );
    }

    public function test_fetching_approved_testimonials_executes_in_less_than_5ms(): void
    {
        for ($i = 0; $i < 10; $i++) {
            Testimonial::create([
                'name' => "Client {$i}",
                'text' => "Great service {$i}",
                'rating' => 5,
                'is_approved' => true
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            Testimonial::create([
                'name' => "Pending Client {$i}",
                'text' => "Pending review {$i}",
                'rating' => 4,
                'is_approved' => false
            ]);
        }

        $startTime = microtime(true);
        $testimonials = Testimonial::where('is_approved', true)->latest()->get();
        $endTime = microtime(true);

        $this->assertCount(10, $testimonials);

        $queryTimeMs = ($endTime - $startTime) * 1000;
        $this->assertLessThan(
            5.0,
            $queryTimeMs,
            "Testimonial database query took {$queryTimeMs} ms which exceeds the 5 ms acceptance criterion limit!"
        );

        $response = $this->get('/api/testimonials');
        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }
}
