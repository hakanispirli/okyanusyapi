<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        try {
            $brands = Brand::orderBy('created_at', 'desc')->paginate(10);

            return view('admin.brands.index', compact('brands'));
        } catch (\Exception $e) {
            Log::error('Markalar listelenirken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            return view('admin.brands.index', ['brands' => collect()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();

            // Ensure directory exists
            $uploadPath = public_path('images/brands');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Handle brand images upload
            if ($request->hasFile('brands_images')) {
                $brandImages = [];
                foreach ($request->file('brands_images') as $index => $image) {
                    $imageName = 'brand_' . time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                    $image->move($uploadPath, $imageName);
                    $brandImages[] = [
                        'url' => asset('images/brands/' . $imageName),
                        'alt' => $request->input('name') . ' - Marka ' . ($index + 1)
                    ];
                }
                $data['brands_images'] = $brandImages;
            }

            // Handle status checkbox (unchecked checkbox doesn't send value)
            $data['status'] = $request->has('status') ? true : false;

            Brand::create($data);

            return redirect()
                ->route('admin.brands.index')
                ->with('success', 'Marka başarıyla oluşturuldu.');
        } catch (\Exception $e) {
            Log::error('Marka oluşturulurken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Marka oluşturulurken bir hata oluştu.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand): View
    {
        return view('admin.brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand): View
    {
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand): RedirectResponse
    {
        try {
            $data = $request->validated();

            // Ensure directory exists
            $uploadPath = public_path('images/brands');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Handle removed images
            $existingBrandImages = $brand->brands_images ?? [];
            $removedImageIndexes = $request->input('removed_images', []);

            // Remove images that were marked for deletion
            if (!empty($removedImageIndexes)) {
                foreach ($removedImageIndexes as $removedIndex) {
                    if (isset($existingBrandImages[$removedIndex])) {
                        // Delete file from server
                        $imageUrl = $existingBrandImages[$removedIndex]['url'] ?? '';
                        if ($imageUrl && File::exists(public_path(str_replace(asset(''), '', $imageUrl)))) {
                            File::delete(public_path(str_replace(asset(''), '', $imageUrl)));
                        }
                        // Remove from array
                        unset($existingBrandImages[$removedIndex]);
                    }
                }
                // Re-index array
                $existingBrandImages = array_values($existingBrandImages);
            }

            // Handle brand images upload - append new images to existing ones
            if ($request->hasFile('brands_images')) {
                $newBrandImages = [];

                foreach ($request->file('brands_images') as $index => $image) {
                    $imageName = 'brand_' . time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                    $image->move($uploadPath, $imageName);
                    $newBrandImages[] = [
                        'url' => asset('images/brands/' . $imageName),
                        'alt' => $request->input('name') . ' - Marka ' . (count($existingBrandImages) + $index + 1)
                    ];
                }

                // Merge existing and new brand images
                $data['brands_images'] = array_merge($existingBrandImages, $newBrandImages);
            } else {
                // If no new images uploaded, keep existing ones (after removal)
                $data['brands_images'] = $existingBrandImages;
            }

            // Handle status checkbox (unchecked checkbox doesn't send value)
            $data['status'] = $request->has('status') ? true : false;

            $brand->update($data);

            return redirect()
                ->route('admin.brands.index')
                ->with('success', 'Marka başarıyla güncellendi.');
        } catch (\Exception $e) {
            Log::error('Marka güncellenirken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Marka güncellenirken bir hata oluştu.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand): RedirectResponse
    {
        try {
            // Delete associated files
            if ($brand->brands_images) {
                foreach ($brand->brands_images as $image) {
                    if (isset($image['url']) && File::exists(public_path(str_replace(asset(''), '', $image['url'])))) {
                        File::delete(public_path(str_replace(asset(''), '', $image['url'])));
                    }
                }
            }

            $brand->delete();

            return redirect()
                ->route('admin.brands.index')
                ->with('success', 'Marka başarıyla silindi.');
        } catch (\Exception $e) {
            Log::error('Marka silinirken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Marka silinirken bir hata oluştu.');
        }
    }
}
