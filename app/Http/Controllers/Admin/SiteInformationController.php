<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSiteInformationRequest;
use App\Http\Requests\UpdateSiteInformationRequest;
use App\Models\SiteInformation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class SiteInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        try {
            $siteInfo = SiteInformation::first();

            return view('admin.site-information.index', compact('siteInfo'));
        } catch (\Exception $e) {
            Log::error('Site bilgileri listelenirken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            return view('admin.site-information.index', ['siteInfo' => null]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.site-information.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSiteInformationRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();

            // Ensure directory exists
            $uploadPath = public_path('images/site');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Handle header logo upload
            if ($request->hasFile('header_logo')) {
                $headerLogo = $request->file('header_logo');
                $headerLogoName = 'header_logo_' . time() . '.' . $headerLogo->getClientOriginalExtension();
                $headerLogo->move($uploadPath, $headerLogoName);
                $data['header_logo'] = 'images/site/' . $headerLogoName;
            }

            // Handle footer logo upload
            if ($request->hasFile('footer_logo')) {
                $footerLogo = $request->file('footer_logo');
                $footerLogoName = 'footer_logo_' . time() . '.' . $footerLogo->getClientOriginalExtension();
                $footerLogo->move($uploadPath, $footerLogoName);
                $data['footer_logo'] = 'images/site/' . $footerLogoName;
            }

            // Handle favicon upload
            if ($request->hasFile('favicon')) {
                $favicon = $request->file('favicon');
                $faviconName = 'favicon_' . time() . '.' . $favicon->getClientOriginalExtension();
                $favicon->move($uploadPath, $faviconName);
                $data['favicon'] = 'images/site/' . $faviconName;
            }

            SiteInformation::create($data);

            return redirect()
                ->route('admin.site-information.index')
                ->with('success', 'Site bilgileri başarıyla oluşturuldu.');
        } catch (\Exception $e) {
            Log::error('Site bilgileri oluşturulurken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Site bilgileri oluşturulurken bir hata oluştu.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SiteInformation $siteInformation): View
    {
        return view('admin.site-information.show', compact('siteInformation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SiteInformation $siteInformation): View
    {
        return view('admin.site-information.edit', compact('siteInformation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSiteInformationRequest $request, SiteInformation $siteInformation): RedirectResponse
    {
        try {
            $data = $request->validated();

            // Ensure directory exists
            $uploadPath = public_path('images/site');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Handle header logo upload
            if ($request->hasFile('header_logo')) {
                // Delete old file
                if ($siteInformation->header_logo && File::exists(public_path($siteInformation->header_logo))) {
                    File::delete(public_path($siteInformation->header_logo));
                }

                $headerLogo = $request->file('header_logo');
                $headerLogoName = 'header_logo_' . time() . '.' . $headerLogo->getClientOriginalExtension();
                $headerLogo->move($uploadPath, $headerLogoName);
                $data['header_logo'] = 'images/site/' . $headerLogoName;
            }

            // Handle footer logo upload
            if ($request->hasFile('footer_logo')) {
                // Delete old file
                if ($siteInformation->footer_logo && File::exists(public_path($siteInformation->footer_logo))) {
                    File::delete(public_path($siteInformation->footer_logo));
                }

                $footerLogo = $request->file('footer_logo');
                $footerLogoName = 'footer_logo_' . time() . '.' . $footerLogo->getClientOriginalExtension();
                $footerLogo->move($uploadPath, $footerLogoName);
                $data['footer_logo'] = 'images/site/' . $footerLogoName;
            }

            // Handle favicon upload
            if ($request->hasFile('favicon')) {
                // Delete old file
                if ($siteInformation->favicon && File::exists(public_path($siteInformation->favicon))) {
                    File::delete(public_path($siteInformation->favicon));
                }

                $favicon = $request->file('favicon');
                $faviconName = 'favicon_' . time() . '.' . $favicon->getClientOriginalExtension();
                $favicon->move($uploadPath, $faviconName);
                $data['favicon'] = 'images/site/' . $faviconName;
            }

            $siteInformation->update($data);

            return redirect()
                ->route('admin.site-information.index')
                ->with('success', 'Site bilgileri başarıyla güncellendi.');
        } catch (\Exception $e) {
            Log::error('Site bilgileri güncellenirken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Site bilgileri güncellenirken bir hata oluştu.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SiteInformation $siteInformation): RedirectResponse
    {
        try {
            // Delete associated files
            if ($siteInformation->header_logo && File::exists(public_path($siteInformation->header_logo))) {
                File::delete(public_path($siteInformation->header_logo));
            }

            if ($siteInformation->footer_logo && File::exists(public_path($siteInformation->footer_logo))) {
                File::delete(public_path($siteInformation->footer_logo));
            }

            if ($siteInformation->favicon && File::exists(public_path($siteInformation->favicon))) {
                File::delete(public_path($siteInformation->favicon));
            }

            $siteInformation->delete();

            return redirect()
                ->route('admin.site-information.index')
                ->with('success', 'Site bilgileri başarıyla silindi.');
        } catch (\Exception $e) {
            Log::error('Site bilgileri silinirken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Site bilgileri silinirken bir hata oluştu.');
        }
    }
}
