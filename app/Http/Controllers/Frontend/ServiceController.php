<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Models\Service;
use App\Services\SeoService;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Display the services listing page.
     */
    public function index(): View
    {
        try {
            $services = Service::active()->orderBy('created_at', 'desc')->get();

            // Generate SEO data
            $seoService = new SeoService();
            $seoData = $seoService->generateSeo(null, 'services');

            return view('frontend.services.index', compact('services', 'seoData'));
        } catch (\Exception $e) {
            Log::error('Error in ServiceController@index: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id() ?? null,
            ]);

            // Fallback SEO data
            $seoService = new SeoService();
            $seoData = $seoService->generateSeo(null, 'services');

            return view('frontend.services.index', [
                'services' => collect(),
                'seoData' => $seoData,
            ]);
        }
    }

    /**
     * Display the specified service detail page.
     */
    public function show(Service $service)
    {
        try {
            // Generate SEO data
            $seoService = new SeoService();
            $seoData = $seoService->generateSeo($service, 'service');

            return view('frontend.services.show', compact('service', 'seoData'));
        } catch (\Exception $e) {
            Log::error('Error in ServiceController@show: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id() ?? null,
                'service_id' => $service->id ?? null,
            ]);

            return redirect()->route('services')->with('error', 'Hizmet bulunamadı.');
        }
    }
}
