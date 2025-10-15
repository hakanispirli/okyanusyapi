<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        try {
            $blogs = Blog::with(['category', 'author'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('admin.blogs.index', compact('blogs'));
        } catch (\Exception $e) {
            Log::error('Bloglar listelenirken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            return view('admin.blogs.index', ['blogs' => collect()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        try {
            $categories = BlogCategory::active()->orderBy('name')->get();

            return view('admin.blogs.create', compact('categories'));
        } catch (\Exception $e) {
            Log::error('Blog oluşturma formu yüklenirken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            return view('admin.blogs.create', ['categories' => collect()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();

            // Ensure directory exists
            $uploadPath = public_path('images/blogs');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Handle featured image upload
            if ($request->hasFile('featured_image')) {
                $featuredImage = $request->file('featured_image');
                $featuredImageName = 'featured_' . time() . '.' . $featuredImage->getClientOriginalExtension();
                $featuredImage->move($uploadPath, $featuredImageName);
                $data['featured_image'] = 'images/blogs/' . $featuredImageName;
            }

            // Handle gallery images upload
            if ($request->hasFile('gallery_images')) {
                $galleryImages = [];
                foreach ($request->file('gallery_images') as $index => $image) {
                    $imageName = 'gallery_' . time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                    $image->move($uploadPath, $imageName);
                    $galleryImages[] = [
                        'url' => asset('images/blogs/' . $imageName),
                        'alt' => $request->input('title') . ' - Galeri Resmi ' . ($index + 1)
                    ];
                }
                $data['gallery_images'] = $galleryImages;
            }

            // Set author
            $data['author_id'] = Auth::id();

            // Handle status checkbox
            $data['status'] = $request->has('status') ? true : false;
            $data['featured'] = $request->has('featured') ? true : false;

            // Set published_at if status is true and published_at is not set
            if ($data['status'] && empty($data['published_at'])) {
                $data['published_at'] = now();
            }

            // Handle tags
            $this->handleTags($data);

            $blog = Blog::create($data);

            return redirect()
                ->route('admin.blogs.index')
                ->with('success', 'Blog yazısı başarıyla oluşturuldu.');
        } catch (\Exception $e) {
            Log::error('Blog oluşturulurken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Blog oluşturulurken bir hata oluştu.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        try {
            $blog->load(['category', 'author']);

            return view('admin.blogs.show', compact('blog'));
        } catch (\Exception $e) {
            Log::error('Blog görüntülenirken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
                'blog_id' => $blog->id ?? null,
            ]);

            return redirect()
                ->route('admin.blogs.index')
                ->with('error', 'Blog görüntülenirken bir hata oluştu.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        try {
            $categories = BlogCategory::active()->orderBy('name')->get();
            $blog->load(['category', 'author']);

            return view('admin.blogs.edit', compact('blog', 'categories'));
        } catch (\Exception $e) {
            Log::error('Blog düzenleme formu yüklenirken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
                'blog_id' => $blog->id ?? null,
            ]);

            return redirect()
                ->route('admin.blogs.index')
                ->with('error', 'Blog düzenleme formu yüklenirken bir hata oluştu.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog): RedirectResponse
    {
        try {
            $data = $request->validated();

            // Ensure directory exists
            $uploadPath = public_path('images/blogs');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Handle featured image upload
            if ($request->hasFile('featured_image')) {
                // Delete old file
                if ($blog->featured_image && File::exists(public_path($blog->featured_image))) {
                    File::delete(public_path($blog->featured_image));
                }

                $featuredImage = $request->file('featured_image');
                $featuredImageName = 'featured_' . time() . '.' . $featuredImage->getClientOriginalExtension();
                $featuredImage->move($uploadPath, $featuredImageName);
                $data['featured_image'] = 'images/blogs/' . $featuredImageName;
            }

            // Handle gallery images upload - append new images to existing ones
            if ($request->hasFile('gallery_images')) {
                $existingGalleryImages = $blog->gallery_images ?? [];
                $newGalleryImages = [];

                foreach ($request->file('gallery_images') as $index => $image) {
                    $imageName = 'gallery_' . time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                    $image->move($uploadPath, $imageName);
                    $newGalleryImages[] = [
                        'url' => asset('images/blogs/' . $imageName),
                        'alt' => $request->input('title') . ' - Galeri Resmi ' . (count($existingGalleryImages) + $index + 1)
                    ];
                }

                // Merge existing and new gallery images
                $data['gallery_images'] = array_merge($existingGalleryImages, $newGalleryImages);
            }

            // Handle status checkbox
            $data['status'] = $request->has('status') ? true : false;
            $data['featured'] = $request->has('featured') ? true : false;

            // Set published_at if status is true and published_at is not set
            if ($data['status'] && empty($data['published_at'])) {
                $data['published_at'] = now();
            }

            // Handle tags
            $this->handleTags($data, $blog);

            $blog->update($data);

            return redirect()
                ->route('admin.blogs.index')
                ->with('success', 'Blog yazısı başarıyla güncellendi.');
        } catch (\Exception $e) {
            Log::error('Blog güncellenirken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Blog güncellenirken bir hata oluştu.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog): RedirectResponse
    {
        try {
            // Delete associated files
            if ($blog->featured_image && File::exists(public_path($blog->featured_image))) {
                File::delete(public_path($blog->featured_image));
            }

            // Delete gallery images
            if ($blog->gallery_images) {
                foreach ($blog->gallery_images as $image) {
                    $imagePath = str_replace(asset(''), '', $image['url']);
                    if (File::exists(public_path($imagePath))) {
                        File::delete(public_path($imagePath));
                    }
                }
            }

            // Handle tags cleanup
            $this->handleTagsCleanup($blog);

            $blog->delete();

            return redirect()
                ->route('admin.blogs.index')
                ->with('success', 'Blog yazısı başarıyla silindi.');
        } catch (\Exception $e) {
            Log::error('Blog silinirken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Blog silinirken bir hata oluştu.');
        }
    }

    /**
     * Handle tags for blog creation and update.
     */
    private function handleTags(array &$data, ?Blog $blog = null): void
    {
        if (empty($data['tags']) || (is_string($data['tags']) && trim($data['tags']) === '')) {
            $data['tags'] = [];
            return;
        }

        $tagNames = is_string($data['tags']) ? explode(',', $data['tags']) : $data['tags'];
        $tagNames = array_map('trim', $tagNames);
        $tagNames = array_filter($tagNames); // Remove empty values

        $processedTags = [];

        foreach ($tagNames as $tagName) {
            if (empty($tagName)) continue;

            // Find existing tag or create new one
            $tag = BlogTag::firstOrCreate(
                ['name' => $tagName],
                [
                    'slug' => \Illuminate\Support\Str::slug($tagName),
                    'status' => true,
                    'usage_count' => 0,
                ]
            );

            // Increment usage count
            $tag->incrementUsage();
            $processedTags[] = $tagName;
        }

        // If updating, decrement usage count for removed tags
        if ($blog && $blog->tags) {
            $oldTags = is_array($blog->tags) ? $blog->tags : [];
            $removedTags = array_diff($oldTags, $processedTags);

            foreach ($removedTags as $removedTagName) {
                $tag = BlogTag::where('name', $removedTagName)->first();
                if ($tag) {
                    $tag->decrementUsage();
                }
            }
        }

        $data['tags'] = $processedTags;
    }

    /**
     * Handle tags cleanup when blog is deleted.
     */
    private function handleTagsCleanup(Blog $blog): void
    {
        if ($blog->tags) {
            $tagNames = is_array($blog->tags) ? $blog->tags : [];

            foreach ($tagNames as $tagName) {
                $tag = BlogTag::where('name', $tagName)->first();
                if ($tag) {
                    $tag->decrementUsage();
                }
            }
        }
    }
}
