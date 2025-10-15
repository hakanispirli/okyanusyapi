<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Http\Controllers\Controller;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Display the blogs listing page.
     */
    public function index(Request $request): View
    {
        try {
            $query = Blog::published()->with(['category', 'author']);

            // Filter by category if provided
            if ($request->has('category') && $request->category) {
                $query->whereHas('category', function ($q) use ($request) {
                    $q->where('slug', $request->category);
                });
            }

            // Filter by tag if provided
            if ($request->has('tag') && $request->tag) {
                $query->whereJsonContains('tags', $request->tag);
            }

            // Search functionality
            if ($request->has('search') && $request->search) {
                $searchTerm = $request->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('title', 'like', "%{$searchTerm}%")
                      ->orWhere('excerpt', 'like', "%{$searchTerm}%")
                      ->orWhere('content', 'like', "%{$searchTerm}%");
                });
            }

            // Order by published date
            $query->latest('published_at');

            $blogs = $query->paginate(9);

            // Get categories for sidebar
            $categories = BlogCategory::active()
                ->withCount('publishedBlogs')
                ->orderBy('name')
                ->get();

            // Get popular tags
            $popularTags = BlogTag::active()
                ->popular()
                ->where('usage_count', '>', 0)
                ->limit(10)
                ->get();

            // Get featured blogs
            $featuredBlogs = Blog::published()
                ->featured()
                ->with(['category', 'author'])
                ->latest('published_at')
                ->limit(3)
                ->get();

            // Generate SEO data
            $seoService = new SeoService();
            $seoData = $seoService->generateSeo(null, 'blogs');

            return view('frontend.blogs.index', compact(
                'blogs',
                'categories',
                'popularTags',
                'featuredBlogs',
                'seoData'
            ));
        } catch (\Exception $e) {
            Log::error('Bloglar listelenirken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
            ]);

            // Fallback SEO data
            $seoService = new SeoService();
            $seoData = $seoService->generateSeo(null, 'blogs');

            return view('frontend.blogs.index', [
                'blogs' => collect(),
                'categories' => collect(),
                'popularTags' => collect(),
                'featuredBlogs' => collect(),
                'seoData' => $seoData,
            ]);
        }
    }

    /**
     * Display blogs by category.
     */
    public function category(BlogCategory $category): View
    {
        try {
            // Check if category is active
            if (!$category->status) {
                abort(404);
            }

            $query = Blog::published()
                ->where('category_id', $category->id)
                ->with(['category', 'author']);

            // Filter by tag if provided
            if (request()->has('tag') && request()->tag) {
                $query->whereJsonContains('tags', request()->tag);
            }

            // Search functionality
            if (request()->has('search') && request()->search) {
                $searchTerm = request()->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('title', 'like', "%{$searchTerm}%")
                      ->orWhere('excerpt', 'like', "%{$searchTerm}%")
                      ->orWhere('content', 'like', "%{$searchTerm}%");
                });
            }

            // Order by published date
            $query->latest('published_at');

            $blogs = $query->paginate(9);

            // Get categories for sidebar
            $categories = BlogCategory::active()
                ->withCount('publishedBlogs')
                ->orderBy('name')
                ->get();

            // Get popular tags
            $popularTags = BlogTag::active()
                ->popular()
                ->where('usage_count', '>', 0)
                ->limit(10)
                ->get();

            // Get featured blogs
            $featuredBlogs = Blog::published()
                ->featured()
                ->with(['category', 'author'])
                ->latest('published_at')
                ->limit(3)
                ->get();

            // Generate SEO data
            $seoService = new SeoService();
            $seoData = $seoService->generateSeo($category, 'blog-category');

            return view('frontend.blogs.category', compact(
                'category',
                'blogs',
                'categories',
                'popularTags',
                'featuredBlogs',
                'seoData'
            ));
        } catch (\Exception $e) {
            Log::error('Kategori blogları listelenirken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'category_id' => $category->id ?? null,
            ]);

            abort(404);
        }
    }

    /**
     * Display blogs by tag.
     */
    public function tag(BlogTag $tag): View
    {
        try {
            // Check if tag is active
            if (!$tag->status) {
                abort(404);
            }

            $query = Blog::published()
                ->whereJsonContains('tags', $tag->name)
                ->with(['category', 'author']);

            // Search functionality
            if (request()->has('search') && request()->search) {
                $searchTerm = request()->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('title', 'like', "%{$searchTerm}%")
                      ->orWhere('excerpt', 'like', "%{$searchTerm}%")
                      ->orWhere('content', 'like', "%{$searchTerm}%");
                });
            }

            // Order by published date
            $query->latest('published_at');

            $blogs = $query->paginate(9);

            // Get categories for sidebar
            $categories = BlogCategory::active()
                ->withCount('publishedBlogs')
                ->orderBy('name')
                ->get();

            // Get popular tags
            $popularTags = BlogTag::active()
                ->popular()
                ->where('usage_count', '>', 0)
                ->limit(10)
                ->get();

            // Get featured blogs
            $featuredBlogs = Blog::published()
                ->featured()
                ->with(['category', 'author'])
                ->latest('published_at')
                ->limit(3)
                ->get();

            // Generate SEO data
            $seoService = new SeoService();
            $seoData = $seoService->generateSeo($tag, 'blog-tag');

            return view('frontend.blogs.tag', compact(
                'tag',
                'blogs',
                'categories',
                'popularTags',
                'featuredBlogs',
                'seoData'
            ));
        } catch (\Exception $e) {
            Log::error('Tag blogları listelenirken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'tag_id' => $tag->id ?? null,
            ]);

            abort(404);
        }
    }

    /**
     * Display the specified blog detail page.
     */
    public function show(Blog $blog): View
    {
        try {
            // Check if blog is published
            if (!$blog->status || !$blog->published_at || $blog->published_at > now()) {
                abort(404);
            }

            // Load relationships
            $blog->load(['category', 'author']);

            // Increment view count
            $blog->incrementViews();

            // Get related blogs by tags
            $relatedBlogs = $blog->getRelatedBlogsByTags(4);

            // Get recent blogs from same category
            $recentBlogs = Blog::published()
                ->where('category_id', $blog->category_id)
                ->where('id', '!=', $blog->id)
                ->with(['category', 'author'])
                ->latest('published_at')
                ->limit(3)
                ->get();

            // Get popular tags
            $popularTags = BlogTag::active()
                ->popular()
                ->where('usage_count', '>', 0)
                ->limit(10)
                ->get();

            // Get categories for sidebar
            $categories = BlogCategory::active()
                ->withCount('publishedBlogs')
                ->orderBy('name')
                ->get();

            // Generate SEO data
            $seoService = new SeoService();
            $seoData = $seoService->generateSeo($blog, 'blog');

            return view('frontend.blogs.show', compact(
                'blog',
                'relatedBlogs',
                'recentBlogs',
                'popularTags',
                'categories',
                'seoData'
            ));
        } catch (\Exception $e) {
            Log::error('Blog görüntülenirken hata oluştu: ' . $e->getMessage(), [
                'exception' => $e,
                'blog_id' => $blog->id ?? null,
            ]);

            abort(404);
        }
    }
}
