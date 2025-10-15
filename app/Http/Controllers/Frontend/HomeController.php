<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $brands = Brand::active()->get();

            return view('frontend.home.index', compact('brands'));
        } catch (\Exception $e) {
            Log::error('Error in HomeController@index: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id() ?? null,
            ]);

            return view('frontend.home.index', [
                'brands' => collect(),
            ]);
        }
    }
}
