<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        try {
            $services = Service::orderBy('created_at', 'desc')->paginate(10);

            return view('admin.services.index', compact('services'));
        } catch (\Exception $e) {
            Log::error('Hizmetler listelenirken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            // Return empty paginated result instead of collection
            $services = Service::whereRaw('1 = 0')->paginate(10);
            return view('admin.services.index', compact('services'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();

            // Ensure directory exists
            $uploadPath = public_path('images/services');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Handle hero image upload
            if ($request->hasFile('hero_image')) {
                $heroImage = $request->file('hero_image');
                $heroImageName = 'hero_' . time() . '.' . $heroImage->getClientOriginalExtension();
                $heroImage->move($uploadPath, $heroImageName);
                $data['hero_image'] = 'images/services/' . $heroImageName;
            }

            // Handle gallery images upload
            if ($request->hasFile('gallery_images')) {
                $galleryImages = [];
                foreach ($request->file('gallery_images') as $index => $image) {
                    $imageName = 'gallery_' . time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                    $image->move($uploadPath, $imageName);
                    $galleryImages[] = [
                        'url' => asset('images/services/' . $imageName),
                        'alt' => $request->input('name') . ' - Galeri Resmi ' . ($index + 1)
                    ];
                }
                $data['gallery_images'] = $galleryImages;
            }

            // Generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            // Handle status checkbox (unchecked checkbox doesn't send value)
            $data['status'] = $request->has('status') ? true : false;

            Service::create($data);

            return redirect()
                ->route('admin.services.index')
                ->with('success', 'Hizmet başarıyla oluşturuldu.');
        } catch (\Exception $e) {
            Log::error('Hizmet oluşturulurken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Hizmet oluşturulurken bir hata oluştu.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service): View
    {
        return view('admin.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service): View
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        try {
            $data = $request->validated();

            // Ensure directory exists
            $uploadPath = public_path('images/services');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Handle hero image upload
            if ($request->hasFile('hero_image')) {
                // Delete old file
                if ($service->hero_image && File::exists(public_path($service->hero_image))) {
                    File::delete(public_path($service->hero_image));
                }

                $heroImage = $request->file('hero_image');
                $heroImageName = 'hero_' . time() . '.' . $heroImage->getClientOriginalExtension();
                $heroImage->move($uploadPath, $heroImageName);
                $data['hero_image'] = 'images/services/' . $heroImageName;
            }

            // Handle gallery images upload - append new images to existing ones
            if ($request->hasFile('gallery_images')) {
                $existingGalleryImages = $service->gallery_images ?? [];
                $newGalleryImages = [];

                foreach ($request->file('gallery_images') as $index => $image) {
                    $imageName = 'gallery_' . time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                    $image->move($uploadPath, $imageName);
                    $newGalleryImages[] = [
                        'url' => asset('images/services/' . $imageName),
                        'alt' => $request->input('name') . ' - Galeri Resmi ' . (count($existingGalleryImages) + $index + 1)
                    ];
                }

                // Merge existing and new gallery images
                $data['gallery_images'] = array_merge($existingGalleryImages, $newGalleryImages);
            }

            // Generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            // Handle status checkbox (unchecked checkbox doesn't send value)
            $data['status'] = $request->has('status') ? true : false;

            $service->update($data);

            return redirect()
                ->route('admin.services.index')
                ->with('success', 'Hizmet başarıyla güncellendi.');
        } catch (\Exception $e) {
            Log::error('Hizmet güncellenirken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Hizmet güncellenirken bir hata oluştu.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service): RedirectResponse
    {
        try {
            // Delete associated files
            if ($service->hero_image && File::exists(public_path($service->hero_image))) {
                File::delete(public_path($service->hero_image));
            }

            $service->delete();

            return redirect()
                ->route('admin.services.index')
                ->with('success', 'Hizmet başarıyla silindi.');
        } catch (\Exception $e) {
            Log::error('Hizmet silinirken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Hizmet silinirken bir hata oluştu.');
        }
    }
}
