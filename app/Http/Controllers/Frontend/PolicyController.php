<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PolicyController extends Controller
{
    public function privacyPolicy()
    {
        try {
            // Generate SEO data
            $seoService = new SeoService();
            $seoData = $seoService->generateSeo(null, 'privacy-policy');

            return view('frontend.policies.privacy-policy', compact('seoData'));
        } catch (\Exception $e) {
            Log::error('An error occurred in privacyPolicy: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::user()?->id,
            ]);
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }

    public function cookiePolicy()
    {
        try {
            // Generate SEO data
            $seoService = new SeoService();
            $seoData = $seoService->generateSeo(null, 'cookie-policy');

            return view('frontend.policies.cookie-policy', compact('seoData'));
        } catch (\Exception $e) {
            Log::error('An error occurred in cookiePolicy: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::user()?->id,
            ]);
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }

    public function termsConditions()
    {
        try {
            // Generate SEO data
            $seoService = new SeoService();
            $seoData = $seoService->generateSeo(null, 'terms-conditions');

            return view('frontend.policies.terms-conditions', compact('seoData'));
        } catch (\Exception $e) {
            Log::error('An error occurred in termsConditions: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::user()?->id,
            ]);
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }
}
