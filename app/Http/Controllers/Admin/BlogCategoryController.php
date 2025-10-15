<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogCategoryRequest;
use App\Http\Requests\UpdateBlogCategoryRequest;
use App\Models\BlogCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        try {
            $categories = BlogCategory::orderBy('created_at', 'desc')->paginate(10);

            return view('admin.blog-categories.index', compact('categories'));
        } catch (\Exception $e) {
            Log::error('Blog kategorileri listelenirken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            return view('admin.blog-categories.index', ['categories' => collect()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.blog-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogCategoryRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();

            // Handle status checkbox (unchecked checkbox doesn't send value)
            $data['status'] = $request->has('status') ? true : false;

            BlogCategory::create($data);

            return redirect()
                ->route('admin.blog-categories.index')
                ->with('success', 'Blog kategorisi başarıyla oluşturuldu.');
        } catch (\Exception $e) {
            Log::error('Blog kategorisi oluşturulurken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Blog kategorisi oluşturulurken bir hata oluştu.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogCategory $blogCategory): View
    {
        $category = $blogCategory;
        return view('admin.blog-categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogCategory $blogCategory): View
    {
        $category = $blogCategory;
        return view('admin.blog-categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogCategoryRequest $request, BlogCategory $blogCategory): RedirectResponse
    {
        try {
            $data = $request->validated();

            // Handle status checkbox (unchecked checkbox doesn't send value)
            $data['status'] = $request->has('status') ? true : false;

            $blogCategory->update($data);

            return redirect()
                ->route('admin.blog-categories.index')
                ->with('success', 'Blog kategorisi başarıyla güncellendi.');
        } catch (\Exception $e) {
            Log::error('Blog kategorisi güncellenirken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Blog kategorisi güncellenirken bir hata oluştu.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCategory $blogCategory): RedirectResponse
    {
        try {
            // Check if category has blogs
            if ($blogCategory->blogs()->count() > 0) {
                return redirect()
                    ->back()
                    ->with('error', 'Bu kategoriye ait blog yazıları bulunduğu için silinemez.');
            }

            $blogCategory->delete();

            return redirect()
                ->route('admin.blog-categories.index')
                ->with('success', 'Blog kategorisi başarıyla silindi.');
        } catch (\Exception $e) {
            Log::error('Blog kategorisi silinirken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Blog kategorisi silinirken bir hata oluştu.');
        }
    }
}
