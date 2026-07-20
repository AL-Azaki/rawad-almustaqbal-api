<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Project;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $baseUrl = rtrim(config('app.url', url('/')), '/');

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Static Pages
        $staticUrls = [
            ['path' => '', 'priority' => '1.0', 'changefreq' => 'weekly'],
            ['path' => '/about', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['path' => '/services', 'priority' => '0.9', 'changefreq' => 'monthly'],
            ['path' => '/services/smart-home-solutions-jeddah', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['path' => '/services/electrician-jeddah-abhur', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['path' => '/services/cctv-security-systems-jeddah', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['path' => '/services/network-infrastructure-jeddah', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['path' => '/services/plumbing-maintenance-jeddah', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['path' => '/services/interior-lighting-decor-jeddah', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['path' => '/portfolio', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['path' => '/contact', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ];

        foreach ($staticUrls as $item) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . $baseUrl . $item['path'] . '</loc>' . "\n";
            $xml .= '    <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
            $xml .= '    <changefreq>' . $item['changefreq'] . '</changefreq>' . "\n";
            $xml .= '    <priority>' . $item['priority'] . '</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }

        // Dynamic Services
        $services = Service::where('status', 'active')->get();
        foreach ($services as $service) {
            $lastmod = $service->updated_at ? $service->updated_at->format('Y-m-d') : date('Y-m-d');
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . $baseUrl . '/services/' . $service->id . '</loc>' . "\n";
            $xml .= '    <lastmod>' . $lastmod . '</lastmod>' . "\n";
            $xml .= '    <changefreq>weekly</changefreq>' . "\n";
            $xml .= '    <priority>0.9</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }

        // Dynamic Projects
        $projects = Project::all();
        foreach ($projects as $project) {
            $lastmod = $project->updated_at ? $project->updated_at->format('Y-m-d') : date('Y-m-d');
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . $baseUrl . '/portfolio/' . $project->id . '</loc>' . "\n";
            $xml .= '    <lastmod>' . $lastmod . '</lastmod>' . "\n";
            $xml .= '    <changefreq>weekly</changefreq>' . "\n";
            $xml .= '    <priority>0.8</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        $baseUrl = rtrim(config('app.url', url('/')), '/');
        $content = "User-agent: *\nAllow: /\n\nSitemap: {$baseUrl}/sitemap.xml\n";

        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
