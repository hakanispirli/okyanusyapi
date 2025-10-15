<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\SeoService;
use Illuminate\Support\Facades\Auth;

class AboutController extends Controller
{
    /**
     * Display the about us page.
     */
    public function index(): View
    {
        try {
            // Generate SEO data
            $seoService = new SeoService();
            $seoData = $seoService->generateSeo(null, 'about');

            return view('frontend.about.index', compact('seoData'));
        } catch (\Exception $e) {
            Log::error('Error in AboutController@index: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id() ?? null,
            ]);

            // Fallback SEO data
            $seoService = new SeoService();
            $seoData = $seoService->generateSeo(null, 'about');

            return view('frontend.about.index', [
                'seoData' => $seoData,
                'statistics' => []
            ]);
        }
    }
}
