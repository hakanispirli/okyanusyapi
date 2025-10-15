<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
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
            return view('frontend.contact.index');
        } catch (\Exception $e) {
            Log::error('Error in ContactController@index: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id() ?? null,
            ]);

            return view('frontend.contact.index', [
                'seoData' => [
                    'title' => 'İletişim - Okyanus Yapı',
                    'description' => 'Okyanus Yapı ile iletişime geçin.',
                ],
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
