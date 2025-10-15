<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\SitemapService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate professional XML sitemaps (Yoast/RankMath style - SEO optimized for 2025 standards)';

    /**
     * Sitemap service
     *
     * @var SitemapService
     */
    protected SitemapService $sitemapService;

    /**
     * Create a new command instance.
     */
    public function __construct(SitemapService $sitemapService)
    {
        parent::__construct();
        $this->sitemapService = $sitemapService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->info('🚀 Starting professional sitemap generation (Yoast/RankMath style)...');
            $this->newLine();
            $startTime = microtime(true);

            // Generate all sitemaps
            $result = $this->sitemapService->generateAll();

            if (!$result['success']) {
                $this->error('❌ Failed to generate sitemaps: ' . $result['message']);
                return Command::FAILURE;
            }

            $executionTime = round(microtime(true) - $startTime, 2);

            // Display results
            $this->displayResults($result['sitemaps'], $executionTime);

            // Log results
            $this->logResults($result['sitemaps'], $executionTime);

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('❌ Error generating sitemaps: ' . $e->getMessage());

            Log::error('Error generating sitemaps: ' . $e->getMessage(), [
                'exception' => $e,
            ]);

            return Command::FAILURE;
        }
    }

    /**
     * Display generation results
     */
    private function displayResults(array $sitemaps, float $executionTime): void
    {
        $this->info('✅ Sitemaps generated successfully!');
        $this->newLine();

        // Main sitemap index
        $this->info('📄 Sitemap Index:');
        $this->line('   └─ sitemap.xml (' . ($sitemaps['index']['total_urls'] ?? 0) . ' total URLs)');
        $this->newLine();

        // Individual sitemaps
        $this->info('📁 Individual Sitemaps:');

        if (isset($sitemaps['page'])) {
            $this->line('   ├─ ' . $sitemaps['page']['filename'] . ' (' . $sitemaps['page']['url_count'] . ' URLs)');
        }

        if (isset($sitemaps['service']) && is_array($sitemaps['service']) && count($sitemaps['service']) > 0) {
            $totalServiceUrls = array_sum(array_column($sitemaps['service'], 'url_count'));
            if (count($sitemaps['service']) > 1) {
                $this->line('   ├─ Services (split into ' . count($sitemaps['service']) . ' files, ' . $totalServiceUrls . ' total URLs)');
                foreach ($sitemaps['service'] as $index => $serviceSitemap) {
                    $prefix = $index === count($sitemaps['service']) - 1 ? '   │  └─' : '   │  ├─';
                    $this->line($prefix . ' ' . $serviceSitemap['filename'] . ' (' . $serviceSitemap['url_count'] . ' URLs)');
                }
            } else {
                $this->line('   ├─ ' . $sitemaps['service'][0]['filename'] . ' (' . $totalServiceUrls . ' URLs)');
            }
        }

        if (isset($sitemaps['blog']) && is_array($sitemaps['blog']) && count($sitemaps['blog']) > 0) {
            $totalBlogUrls = array_sum(array_column($sitemaps['blog'], 'url_count'));
            if (count($sitemaps['blog']) > 1) {
                $this->line('   ├─ Blogs (split into ' . count($sitemaps['blog']) . ' files, ' . $totalBlogUrls . ' total URLs)');
                foreach ($sitemaps['blog'] as $index => $blogSitemap) {
                    $prefix = $index === count($sitemaps['blog']) - 1 ? '   │  └─' : '   │  ├─';
                    $this->line($prefix . ' ' . $blogSitemap['filename'] . ' (' . $blogSitemap['url_count'] . ' URLs)');
                }
            } else {
                $this->line('   ├─ ' . $sitemaps['blog'][0]['filename'] . ' (' . $totalBlogUrls . ' URLs)');
            }
        }

        if (isset($sitemaps['blog_category'])) {
            $this->line('   ├─ ' . $sitemaps['blog_category']['filename'] . ' (' . $sitemaps['blog_category']['url_count'] . ' URLs)');
        }

        if (isset($sitemaps['policy'])) {
            $this->line('   └─ ' . $sitemaps['policy']['filename'] . ' (' . $sitemaps['policy']['url_count'] . ' URLs)');
        }

        $this->newLine();
        $this->info('⚡ Execution time: ' . $executionTime . 's');
        $this->info('📍 Location: ' . public_path());
        $this->newLine();

        // Tips
        $this->comment('💡 Tips:');
        $this->line('   • Submit sitemap.xml to Google Search Console');
        $this->line('   • Sitemap has beautiful Yoast/RankMath style view (XSL stylesheet)');
        $this->line('   • Sitemap will auto-update daily at 02:00 AM via cron job');
    }

    /**
     * Log generation results
     */
    private function logResults(array $sitemaps, float $executionTime): void
    {
        $totalUrls = $sitemaps['index']['total_urls'] ?? 0;

        $details = [
            'execution_time' => $executionTime,
            'total_urls' => $totalUrls,
            'page_urls' => $sitemaps['page']['url_count'] ?? 0,
            'service_urls' => is_array($sitemaps['service'] ?? null)
                ? array_sum(array_column($sitemaps['service'], 'url_count'))
                : 0,
            'service_files' => is_array($sitemaps['service'] ?? null) ? count($sitemaps['service']) : 0,
            'blog_urls' => is_array($sitemaps['blog'] ?? null)
                ? array_sum(array_column($sitemaps['blog'], 'url_count'))
                : 0,
            'blog_files' => is_array($sitemaps['blog'] ?? null) ? count($sitemaps['blog']) : 0,
            'blog_category_urls' => $sitemaps['blog_category']['url_count'] ?? 0,
            'policy_urls' => $sitemaps['policy']['url_count'] ?? 0,
        ];

        Log::info('Professional sitemaps generated successfully (Yoast/RankMath style)', $details);
    }
}
