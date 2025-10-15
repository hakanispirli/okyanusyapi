<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\SeoService;
use App\Mail\ContactMail;
use App\Models\SiteInformation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Display the contact page.
     */
    public function index(): View
    {
        try {
            // Generate SEO data
            $seoService = new SeoService();
            $seoData = $seoService->generateSeo(null, 'contact');

            return view('frontend.contact.index', compact('seoData'));
        } catch (\Exception $e) {
            Log::error('Error in ContactController@index: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id() ?? null,
            ]);

            // Fallback SEO data
            $seoService = new SeoService();
            $seoData = $seoService->generateSeo(null, 'contact');

            return view('frontend.contact.index', [
                'seoData' => $seoData,
            ]);
        }
    }

    /**
     * Handle contact form submission.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'subject' => 'required|string|max:255',
                'message' => 'required|string|max:2000',
            ]);

            // Here you can add email sending logic
            // Mail::to('info@okyanusyapi.com')->send(new ContactMail($validated));

            // Get site information to send email to notification_email
            $siteInformation = SiteInformation::first();

            if ($siteInformation && $siteInformation->notification_email) {
                try {
                    Mail::to($siteInformation->notification_email)->send(new ContactMail($validated));
                } catch (\Exception $mailException) {
                    Log::error('Email gönderilirken hata oluştu: ' . $mailException->getMessage(), [
                        'exception' => $mailException,
                        'contact_data' => $validated,
                        'notification_email' => $siteInformation->notification_email,
                    ]);

                    // Continue with success response even if email fails
                    // The form submission was successful, email failure is secondary
                }
            } else {
                Log::warning('Site bilgilerinde notification_email bulunamadı', [
                    'site_information_exists' => $siteInformation ? true : false,
                    'notification_email' => $siteInformation?->notification_email,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Mesajınız başarıyla gönderildi. En kısa sürede size dönüş yapacağız.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error in ContactController@store: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id() ?? null,
                'request_data' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Mesaj gönderilirken bir hata oluştu. Lütfen tekrar deneyin.'
            ], 500);
        }
    }
}
