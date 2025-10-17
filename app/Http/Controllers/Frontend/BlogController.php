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
                $query->where(function ($q) use ($request) {
                    $q->whereJsonContains('tags', $request->tag)
                      ->orWhere('tags', 'like', '%"' . $request->tag . '"%');
                });
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

            // Preload tag models for all blogs (support both slug and name)
            $allTagNames = collect();
            foreach ($blogs as $blog) {
                if ($blog->tags) {
                    $allTagNames = $allTagNames->merge($blog->tags);
                }
            }
            // Get tags by both slug and name, then create a combined lookup
            $uniqueTags = $allTagNames->unique();
            $tagsBySlug = BlogTag::whereIn('slug', $uniqueTags)->get();
            $tagsByName = BlogTag::whereIn('name', $uniqueTags)->get();
            $allTags = $tagsBySlug->merge($tagsByName)->unique('id');

            // Create lookup by both slug and name
            $tagModels = collect();
            foreach ($allTags as $tag) {
                $tagModels[$tag->slug] = $tag;
                $tagModels[$tag->name] = $tag;
            }

            // Generate SEO data
            $seoService = new SeoService();
            $seoData = $seoService->generateSeo(null, 'blogs');

            return view('frontend.blogs.index', compact(
                'blogs',
                'categories',
                'popularTags',
                'featuredBlogs',
                'tagModels',
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
                'tagModels' => collect(),
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
                $query->where(function ($q) {
                    $tag = request()->tag;
                    $q->whereJsonContains('tags', $tag)
                      ->orWhere('tags', 'like', '%"' . $tag . '"%');
                });
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

            // Preload tag models for all blogs (support both slug and name)
            $allTagNames = collect();
            foreach ($blogs as $blog) {
                if ($blog->tags) {
                    $allTagNames = $allTagNames->merge($blog->tags);
                }
            }
            // Get tags by both slug and name, then create a combined lookup
            $uniqueTags = $allTagNames->unique();
            $tagsBySlug = BlogTag::whereIn('slug', $uniqueTags)->get();
            $tagsByName = BlogTag::whereIn('name', $uniqueTags)->get();
            $allTags = $tagsBySlug->merge($tagsByName)->unique('id');

            // Create lookup by both slug and name
            $tagModels = collect();
            foreach ($allTags as $tag) {
                $tagModels[$tag->slug] = $tag;
                $tagModels[$tag->name] = $tag;
            }

            // Generate SEO data
            $seoService = new SeoService();
            $seoData = $seoService->generateSeo($category, 'blog-category');

            return view('frontend.blogs.category', compact(
                'category',
                'blogs',
                'categories',
                'popularTags',
                'featuredBlogs',
                'tagModels',
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
            Log::info('=== TAG PAGE DEBUG START ===');
            Log::info('Tag Model Info:', [
                'id' => $tag->id,
                'name' => $tag->name,
                'slug' => $tag->slug,
                'status' => $tag->status,
                'usage_count' => $tag->usage_count,
            ]);

            // Check if tag is active
            if (!$tag->status) {
                Log::warning('Tag is not active, aborting', ['tag_id' => $tag->id]);
                abort(404);
            }

            // First, let's see ALL published blogs and their tags
            $allPublishedBlogs = Blog::published()->get();
            Log::info('All Published Blogs Count: ' . $allPublishedBlogs->count());

            foreach ($allPublishedBlogs as $blog) {
                Log::info('Blog ID ' . $blog->id . ' tags:', [
                    'title' => $blog->title,
                    'tags_raw' => $blog->getRawOriginal('tags'),
                    'tags_casted' => $blog->tags,
                    'tags_type' => gettype($blog->tags),
                ]);
            }

            // Search blogs by both tag slug and name for backward compatibility
            $query = Blog::published()
                ->where(function ($q) use ($tag) {
                    // Search by slug (new format)
                    $q->where(function ($subQ) use ($tag) {
                        $subQ->whereJsonContains('tags', $tag->slug)
                             ->orWhere('tags', 'like', '%"' . $tag->slug . '"%');
                    })
                    // Also search by name (old format for existing records)
                    ->orWhere(function ($subQ) use ($tag) {
                        $subQ->whereJsonContains('tags', $tag->name)
                             ->orWhere('tags', 'like', '%"' . $tag->name . '"%');
                    });
                })
                ->with(['category', 'author']);

            // Log the SQL query
            $sql = $query->toSql();
            $bindings = $query->getBindings();
            Log::info('SQL Query:', ['sql' => $sql, 'bindings' => $bindings]);

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

            // Execute query and log results
            $blogs = $query->paginate(9);

            Log::info('Query Results:', [
                'total_found' => $blogs->total(),
                'current_page' => $blogs->currentPage(),
                'per_page' => $blogs->perPage(),
            ]);

            if ($blogs->count() > 0) {
                Log::info('Found Blogs:');
                foreach ($blogs as $blog) {
                    Log::info('- Blog ID ' . $blog->id, [
                        'title' => $blog->title,
                        'tags' => $blog->tags,
                    ]);
                }
            } else {
                Log::warning('NO BLOGS FOUND!');
                Log::info('Trying manual search...');

                // Manual check - does ANY blog have this tag in ANY format?
                $manualCheck = Blog::published()->get()->filter(function($blog) use ($tag) {
                    if (!$blog->tags) return false;

                    foreach ($blog->tags as $blogTag) {
                        Log::info('Comparing:', [
                            'blog_tag' => $blogTag,
                            'search_slug' => $tag->slug,
                            'search_name' => $tag->name,
                            'matches_slug' => ($blogTag === $tag->slug),
                            'matches_name' => ($blogTag === $tag->name),
                        ]);

                        if ($blogTag === $tag->slug || $blogTag === $tag->name) {
                            return true;
                        }
                    }
                    return false;
                });

                Log::info('Manual Search Results: ' . $manualCheck->count() . ' blogs found');
                if ($manualCheck->count() > 0) {
                    foreach ($manualCheck as $blog) {
                        Log::info('Manual found: ' . $blog->title, ['tags' => $blog->tags]);
                    }
                }
            }

            Log::info('=== TAG PAGE DEBUG END ===');

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

            // Preload tag models for all blogs (support both slug and name)
            $allTagNames = collect();
            foreach ($blogs as $blog) {
                if ($blog->tags) {
                    $allTagNames = $allTagNames->merge($blog->tags);
                }
            }
            // Get tags by both slug and name, then create a combined lookup
            $uniqueTags = $allTagNames->unique();
            $tagsBySlug = BlogTag::whereIn('slug', $uniqueTags)->get();
            $tagsByName = BlogTag::whereIn('name', $uniqueTags)->get();
            $allTags = $tagsBySlug->merge($tagsByName)->unique('id');

            // Create lookup by both slug and name
            $tagModels = collect();
            foreach ($allTags as $tag) {
                $tagModels[$tag->slug] = $tag;
                $tagModels[$tag->name] = $tag;
            }

            // Generate SEO data
            $seoService = new SeoService();
            $seoData = $seoService->generateSeo($tag, 'blog-tag');

            return view('frontend.blogs.tag', compact(
                'tag',
                'blogs',
                'categories',
                'popularTags',
                'featuredBlogs',
                'tagModels',
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

            // Preload tag models for current blog (support both slug and name)
            $tagModels = collect();
            if ($blog->tags) {
                $tagsBySlug = BlogTag::whereIn('slug', $blog->tags)->get();
                $tagsByName = BlogTag::whereIn('name', $blog->tags)->get();
                $allTags = $tagsBySlug->merge($tagsByName)->unique('id');

                // Create lookup by both slug and name
                foreach ($allTags as $tag) {
                    $tagModels[$tag->slug] = $tag;
                    $tagModels[$tag->name] = $tag;
                }
            }

            // Generate SEO data
            $seoService = new SeoService();
            $seoData = $seoService->generateSeo($blog, 'blog');

            return view('frontend.blogs.show', compact(
                'blog',
                'relatedBlogs',
                'recentBlogs',
                'popularTags',
                'categories',
                'tagModels',
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
