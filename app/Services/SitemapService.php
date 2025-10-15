<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Service;
use Illuminate\Support\Facades\Log;

class SitemapService
{
    /**
     * Maximum URLs per sitemap file
     */
    private const MAX_URLS_PER_SITEMAP = 2000;

    /**
     * Generate all sitemaps
     */
    public function generateAll(): array
    {
        $sitemaps = [];

        try {
            // Generate individual sitemaps
            $sitemaps['page'] = $this->generatePageSitemap();
            $sitemaps['service'] = $this->generateServicesSitemap();
            $sitemaps['blog'] = $this->generateBlogsSitemap();
            $sitemaps['blog_category'] = $this->generateBlogCategoriesSitemap();
            $sitemaps['policy'] = $this->generatePoliciesSitemap();

            // Generate sitemap index
            $sitemaps['index'] = $this->generateSitemapIndex($sitemaps);

            return [
                'success' => true,
                'sitemaps' => $sitemaps,
            ];
        } catch (\Exception $e) {
            Log::error('Error generating sitemaps: ' . $e->getMessage(), [
                'exception' => $e,
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Generate page sitemap (static pages like homepage, contact, etc.)
     */
    private function generatePageSitemap(): array
    {
        $urls = [];

        // Homepage
        $urls[] = [
            'loc' => config('app.url'),
            'lastmod' => now(),
            'changefreq' => 'daily',
            'priority' => '1.0',
        ];

        // About page
        $urls[] = [
            'loc' => route('about'),
            'lastmod' => now(),
            'changefreq' => 'monthly',
            'priority' => '0.8',
        ];

        // Services list page
        $urls[] = [
            'loc' => route('services'),
            'lastmod' => now(),
            'changefreq' => 'weekly',
            'priority' => '0.9',
        ];

        // Blogs list page
        $urls[] = [
            'loc' => route('blogs'),
            'lastmod' => now(),
            'changefreq' => 'daily',
            'priority' => '0.8',
        ];

        // Contact page
        $urls[] = [
            'loc' => route('contact'),
            'lastmod' => now(),
            'changefreq' => 'monthly',
            'priority' => '0.7',
        ];

        $filename = 'page-sitemap.xml';
        $this->saveSitemap($filename, $urls);

        return [
            'filename' => $filename,
            'url_count' => count($urls),
            'lastmod' => now(),
        ];
    }

    /**
     * Generate services sitemap (with images)
     */
    private function generateServicesSitemap(): array
    {
        $services = Service::where('status', true)
            ->orderBy('updated_at', 'desc')
            ->get();

        $sitemaps = [];
        $urls = [];
        $counter = 0;
        $fileIndex = 1;

        foreach ($services as $service) {
            $images = [];

            // Add service hero image if exists
            if ($service->hero_image) {
                $images[] = [
                    'loc' => $this->getImageUrl($service->hero_image),
                    'title' => $service->title,
                    'caption' => $service->description,
                ];
            }

            // Add gallery images if exists
            if ($service->gallery_images && is_array($service->gallery_images)) {
                foreach (array_slice($service->gallery_images, 0, 5) as $galleryImage) {
                    // Handle both old format (string) and new format (array with url/alt)
                    $imageUrl = is_array($galleryImage) ? ($galleryImage['url'] ?? '') : $galleryImage;
                    $imageAlt = is_array($galleryImage) ? ($galleryImage['alt'] ?? '') : '';

                    if ($imageUrl) {
                        $images[] = [
                            'loc' => $this->getImageUrl($imageUrl),
                            'title' => $service->title . ' - Galeri',
                            'caption' => $imageAlt ?: $service->description,
                        ];
                    }
                }
            }

            $urls[] = [
                'loc' => route('services.show', $service),
                'lastmod' => $service->updated_at,
                'changefreq' => 'weekly',
                'priority' => '0.9',
                'images' => $images,
            ];

            $counter++;

            // Split into multiple files if needed
            if ($counter >= self::MAX_URLS_PER_SITEMAP) {
                $filename = 'sitemap-services-' . $fileIndex . '.xml';
                $this->saveSitemap($filename, $urls, true);

                $sitemaps[] = [
                    'filename' => $filename,
                    'url_count' => count($urls),
                    'lastmod' => now(),
                ];

                $urls = [];
                $counter = 0;
                $fileIndex++;
            }
        }

        // Save remaining URLs
        if (count($urls) > 0) {
            $filename = $fileIndex === 1 ? 'service-sitemap.xml' : 'service-sitemap-' . $fileIndex . '.xml';
            $this->saveSitemap($filename, $urls, true);

            $sitemaps[] = [
                'filename' => $filename,
                'url_count' => count($urls),
                'lastmod' => now(),
            ];
        }

        // If no services found, return empty array
        if (empty($sitemaps)) {
            return [];
        }

        return $sitemaps;
    }

    /**
     * Generate blog categories sitemap
     */
    private function generateBlogCategoriesSitemap(): array
    {
        $categories = BlogCategory::where('status', true)
            ->orderBy('name')
            ->get();
        $urls = [];

        foreach ($categories as $category) {
            $urls[] = [
                'loc' => route('blogs.category', $category),
                'lastmod' => $category->updated_at,
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        $filename = 'blog-category-sitemap.xml';
        $this->saveSitemap($filename, $urls);

        return [
            'filename' => $filename,
            'url_count' => count($urls),
            'lastmod' => now(),
        ];
    }

    /**
     * Generate blogs sitemap (with images)
     */
    private function generateBlogsSitemap(): array
    {
        $blogs = Blog::with('category')
            ->where('status', true)
            ->whereNotNull('published_at')
            ->orderBy('updated_at', 'desc')
            ->get();

        $sitemaps = [];
        $urls = [];
        $counter = 0;
        $fileIndex = 1;

        foreach ($blogs as $blog) {
            $images = [];

            // Add blog featured image if exists
            if ($blog->featured_image) {
                $images[] = [
                    'loc' => $this->getImageUrl($blog->featured_image),
                    'title' => $blog->title,
                    'caption' => $blog->excerpt,
                ];
            }

            // Add gallery images if exists
            if ($blog->gallery_images && is_array($blog->gallery_images)) {
                foreach (array_slice($blog->gallery_images, 0, 5) as $galleryImage) {
                    // Handle both old format (string) and new format (array with url/alt)
                    $imageUrl = is_array($galleryImage) ? ($galleryImage['url'] ?? '') : $galleryImage;
                    $imageAlt = is_array($galleryImage) ? ($galleryImage['alt'] ?? '') : '';

                    if ($imageUrl) {
                        $images[] = [
                            'loc' => $this->getImageUrl($imageUrl),
                            'title' => $blog->title . ' - Galeri',
                            'caption' => $imageAlt ?: $blog->excerpt,
                        ];
                    }
                }
            }

            $urls[] = [
                'loc' => route('blogs.show', $blog),
                'lastmod' => $blog->updated_at,
                'changefreq' => 'weekly',
                'priority' => '0.8',
                'images' => $images,
            ];

            $counter++;

            // Split into multiple files if needed
            if ($counter >= self::MAX_URLS_PER_SITEMAP) {
                $filename = 'sitemap-blogs-' . $fileIndex . '.xml';
                $this->saveSitemap($filename, $urls, true);

                $sitemaps[] = [
                    'filename' => $filename,
                    'url_count' => count($urls),
                    'lastmod' => now(),
                ];

                $urls = [];
                $counter = 0;
                $fileIndex++;
            }
        }

        // Save remaining URLs
        if (count($urls) > 0) {
            $filename = $fileIndex === 1 ? 'blog-sitemap.xml' : 'blog-sitemap-' . $fileIndex . '.xml';
            $this->saveSitemap($filename, $urls, true);

            $sitemaps[] = [
                'filename' => $filename,
                'url_count' => count($urls),
                'lastmod' => now(),
            ];
        }

        // If no blogs found, return empty array
        if (empty($sitemaps)) {
            return [];
        }

        return $sitemaps;
    }

    /**
     * Generate policies sitemap
     */
    private function generatePoliciesSitemap(): array
    {
        $urls = [];

        // Privacy Policy
        $urls[] = [
            'loc' => route('privacy-policy'),
            'lastmod' => now(),
            'changefreq' => 'monthly',
            'priority' => '0.5',
        ];

        // Cookie Policy
        $urls[] = [
            'loc' => route('cookie-policy'),
            'lastmod' => now(),
            'changefreq' => 'monthly',
            'priority' => '0.5',
        ];

        // Terms and Conditions
        $urls[] = [
            'loc' => route('terms-conditions'),
            'lastmod' => now(),
            'changefreq' => 'monthly',
            'priority' => '0.5',
        ];

        $filename = 'policy-sitemap.xml';
        $this->saveSitemap($filename, $urls);

        return [
            'filename' => $filename,
            'url_count' => count($urls),
            'lastmod' => now(),
        ];
    }

    /**
     * Generate sitemap index
     */
    private function generateSitemapIndex(array $sitemaps): array
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xml .= '<?xml-stylesheet type="text/xsl" href="' . config('app.url') . '/sitemap.xsl"?>' . PHP_EOL;
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

        $totalUrls = 0;

        // Add page sitemap
        if (isset($sitemaps['page'])) {
            $xml .= $this->addSitemapIndexEntry(
                $sitemaps['page']['filename'],
                $sitemaps['page']['lastmod']
            );
            $totalUrls += $sitemaps['page']['url_count'];
        }

        // Add service sitemaps
        if (isset($sitemaps['service']) && is_array($sitemaps['service']) && count($sitemaps['service']) > 0) {
            foreach ($sitemaps['service'] as $serviceSitemap) {
                $xml .= $this->addSitemapIndexEntry(
                    $serviceSitemap['filename'],
                    $serviceSitemap['lastmod']
                );
                $totalUrls += $serviceSitemap['url_count'];
            }
        }

        // Add blog sitemaps
        if (isset($sitemaps['blog']) && is_array($sitemaps['blog']) && count($sitemaps['blog']) > 0) {
            foreach ($sitemaps['blog'] as $blogSitemap) {
                $xml .= $this->addSitemapIndexEntry(
                    $blogSitemap['filename'],
                    $blogSitemap['lastmod']
                );
                $totalUrls += $blogSitemap['url_count'];
            }
        }

        // Add blog category sitemap
        if (isset($sitemaps['blog_category'])) {
            $xml .= $this->addSitemapIndexEntry(
                $sitemaps['blog_category']['filename'],
                $sitemaps['blog_category']['lastmod']
            );
            $totalUrls += $sitemaps['blog_category']['url_count'];
        }

        // Add policy sitemap
        if (isset($sitemaps['policy'])) {
            $xml .= $this->addSitemapIndexEntry(
                $sitemaps['policy']['filename'],
                $sitemaps['policy']['lastmod']
            );
            $totalUrls += $sitemaps['policy']['url_count'];
        }

        $xml .= '</sitemapindex>' . PHP_EOL;

        // Save index
        $filename = 'sitemap.xml';
        $path = public_path($filename);
        file_put_contents($path, $xml);

        return [
            'filename' => $filename,
            'total_urls' => $totalUrls,
            'lastmod' => now(),
        ];
    }

    /**
     * Add sitemap entry to index
     */
    private function addSitemapIndexEntry(string $filename, $lastmod): string
    {
        $xml = '  <sitemap>' . PHP_EOL;
        $xml .= '    <loc>' . $this->escapeUrl(config('app.url') . '/' . $filename) . '</loc>' . PHP_EOL;
        $xml .= '    <lastmod>' . $this->formatDate($lastmod) . '</lastmod>' . PHP_EOL;
        $xml .= '  </sitemap>' . PHP_EOL;

        return $xml;
    }

    /**
     * Save sitemap to file
     */
    private function saveSitemap(string $filename, array $urls, bool $includeImages = false): void
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xml .= '<?xml-stylesheet type="text/xsl" href="' . config('app.url') . '/sitemap.xsl"?>' . PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"';

        if ($includeImages) {
            $xml .= PHP_EOL . '        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"';
        }

        $xml .= '>' . PHP_EOL;

        foreach ($urls as $url) {
            $xml .= $this->buildUrlEntry($url);
        }

        $xml .= '</urlset>' . PHP_EOL;

        // Save to public directory
        $path = public_path($filename);
        file_put_contents($path, $xml);
    }

    /**
     * Build URL entry
     */
    private function buildUrlEntry(array $url): string
    {
        $xml = '  <url>' . PHP_EOL;
        $xml .= '    <loc>' . $this->escapeUrl($url['loc']) . '</loc>' . PHP_EOL;
        $xml .= '    <lastmod>' . $this->formatDate($url['lastmod']) . '</lastmod>' . PHP_EOL;
        $xml .= '    <changefreq>' . $url['changefreq'] . '</changefreq>' . PHP_EOL;
        $xml .= '    <priority>' . $url['priority'] . '</priority>' . PHP_EOL;

        // Add images if present
        if (isset($url['images']) && is_array($url['images'])) {
            foreach ($url['images'] as $image) {
                $xml .= $this->buildImageEntry($image);
            }
        }

        $xml .= '  </url>' . PHP_EOL;

        return $xml;
    }

    /**
     * Build image entry
     */
    private function buildImageEntry(array $image): string
    {
        $xml = '    <image:image>' . PHP_EOL;
        $xml .= '      <image:loc>' . $this->escapeUrl($image['loc']) . '</image:loc>' . PHP_EOL;

        if (!empty($image['title'])) {
            $xml .= '      <image:title>' . $this->escapeXml($image['title']) . '</image:title>' . PHP_EOL;
        }

        if (!empty($image['caption'])) {
            $xml .= '      <image:caption>' . $this->escapeXml(substr($image['caption'], 0, 256)) . '</image:caption>' . PHP_EOL;
        }

        $xml .= '    </image:image>' . PHP_EOL;

        return $xml;
    }

    /**
     * Get image URL
     */
    private function getImageUrl(string $imagePath): string
    {
        // Handle empty or null paths
        if (empty($imagePath)) {
            return '';
        }

        // If it's already a full URL, return as is
        if (str_starts_with($imagePath, 'http')) {
            return $imagePath;
        }

        // If it's a relative path, make it absolute
        return config('app.url') . '/' . ltrim($imagePath, '/');
    }

    /**
     * Escape URL for XML
     */
    private function escapeUrl(string $url): string
    {
        return htmlspecialchars($url, ENT_XML1 | ENT_COMPAT, 'UTF-8', false);
    }

    /**
     * Escape text content for XML
     */
    private function escapeXml(string $text): string
    {
        return htmlspecialchars(strip_tags($text), ENT_XML1 | ENT_COMPAT, 'UTF-8', false);
    }

    /**
     * Format date to W3C datetime format
     */
    private function formatDate($date): string
    {
        if ($date instanceof \Carbon\Carbon) {
            return $date->toW3cString();
        }

        return now()->toW3cString();
    }
}

