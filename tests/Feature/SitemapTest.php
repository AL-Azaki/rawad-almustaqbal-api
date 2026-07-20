<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Service;
use App\Models\Project;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_returns_valid_xml_and_derives_base_url_from_app_url(): void
    {
        config(['app.url' => 'https://enterprise-test-domain.sa/']);

        $service = Service::create([
            'title' => 'Electrical Setup',
            'description' => 'Professional electrical installation',
            'status' => 'active'
        ]);

        $project = Project::create([
            'title' => 'Smart Villa',
            'category' => 'Smart Home',
            'description' => 'Complete home automation'
        ]);

        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml');

        $content = $response->getContent();
        $this->assertStringContainsString('<?xml version="1.0" encoding="UTF-8"?>', $content);
        $this->assertStringContainsString('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', $content);

        // Verify Static & Local SEO Area Pages
        $this->assertStringContainsString('<loc>https://enterprise-test-domain.sa</loc>', $content);
        $this->assertStringContainsString('https://enterprise-test-domain.sa/about', $content);
        $this->assertStringContainsString('https://enterprise-test-domain.sa/contact', $content);
        $this->assertStringContainsString('https://enterprise-test-domain.sa/services', $content);
        $this->assertStringContainsString('https://enterprise-test-domain.sa/portfolio', $content);
        $this->assertStringContainsString('https://enterprise-test-domain.sa/services/smart-home-solutions-jeddah', $content);
        $this->assertStringContainsString('https://enterprise-test-domain.sa/services/electrician-jeddah-abhur', $content);
        $this->assertStringContainsString('https://enterprise-test-domain.sa/services/cctv-security-systems-jeddah', $content);
        $this->assertStringContainsString('https://enterprise-test-domain.sa/services/network-infrastructure-jeddah', $content);
        $this->assertStringContainsString('https://enterprise-test-domain.sa/services/plumbing-maintenance-jeddah', $content);
        $this->assertStringContainsString('https://enterprise-test-domain.sa/services/interior-lighting-decor-jeddah', $content);

        // Verify Dynamic Database Entities
        $this->assertStringContainsString('https://enterprise-test-domain.sa/services/' . $service->id, $content);
        $this->assertStringContainsString('https://enterprise-test-domain.sa/portfolio/' . $project->id, $content);

        // Verify No Netlify URLs
        $this->assertStringNotContainsString('netlify.app', $content);
    }

    public function test_sitemap_has_no_duplicated_urls(): void
    {
        config(['app.url' => 'https://enterprise-test-domain.sa']);

        $response = $this->get('/sitemap.xml');
        $content = $response->getContent();

        preg_match_all('/<loc>(.*?)<\/loc>/', $content, $matches);
        $urls = $matches[1];
        $uniqueUrls = array_unique($urls);

        $this->assertCount(count($urls), $uniqueUrls, 'Sitemap contains duplicated URLs!');
    }

    public function test_robots_txt_returns_valid_text_and_points_to_sitemap(): void
    {
        config(['app.url' => 'https://enterprise-test-domain.sa']);

        $response = $this->get('/robots.txt');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/plain; charset=utf-8');

        $content = $response->getContent();
        $this->assertStringContainsString('User-agent: *', $content);
        $this->assertStringContainsString('Allow: /', $content);
        $this->assertStringContainsString('Sitemap: https://enterprise-test-domain.sa/sitemap.xml', $content);
        $this->assertStringNotContainsString('netlify.app', $content);
    }
}

