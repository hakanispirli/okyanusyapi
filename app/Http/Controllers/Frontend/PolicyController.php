<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PolicyController extends Controller
{
    public function privacyPolicy()
    {
        try {
            return view('frontend.policies.privacy-policy');
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
            return view('frontend.policies.cookie-policy');
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
            return view('frontend.policies.terms-conditions');
        } catch (\Exception $e) {
            Log::error('An error occurred in termsConditions: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::user()?->id,
            ]);
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }
}
