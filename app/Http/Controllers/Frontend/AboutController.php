<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AboutController extends Controller
{
    /**
     * Display the about us page.
     */
    public function index(): View
    {
        try {
            return view('frontend.about.index');
        } catch (\Exception $e) {
            Log::error('Error in AboutController@index: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id() ?? null,
            ]);

            return view('frontend.about.index', [
                'seoData' => [
                    'title' => 'Hakkımızda - Okyanus Yapı',
                    'description' => 'Okyanus Yapı hakkında bilgi edinin.',
                ],
                'statistics' => []
            ]);
        }
    }
}
