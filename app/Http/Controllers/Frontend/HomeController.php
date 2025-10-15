<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $brands = Brand::active()->get();

            // Generate SEO data
            $seoService = new SeoService();
            $seoData = $seoService->generateSeo(null, 'home');

            return view('frontend.home.index', compact('brands', 'seoData'));
        } catch (\Exception $e) {
            Log::error('Error in HomeController@index: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id() ?? null,
            ]);

            // Fallback SEO data
            $seoService = new SeoService();
            $seoData = $seoService->generateSeo(null, 'home');

            return view('frontend.home.index', [
                'brands' => collect(),
                'seoData' => $seoData,
            ]);
        }
    }
}
