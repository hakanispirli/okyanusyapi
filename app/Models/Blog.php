<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'category_id',
        'author_id',
        'featured_image',
        'featured_image_alt',
        'gallery_images',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_og',
        'reading_time',
        'views',
        'likes',
        'status',
        'featured',
        'published_at',
        'tags',
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'meta_og' => 'array',
        'tags' => 'array',
        'status' => 'boolean',
        'featured' => 'boolean',
        'reading_time' => 'integer',
        'views' => 'integer',
        'likes' => 'integer',
        'published_at' => 'datetime',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Scope a query to only include published blogs.
     */
    public function scopePublished($query)
    {
        return $query->where('status', true)
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to only include featured blogs.
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope a query to order by published date.
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    /**
     * Scope a query to order by views.
     */
    public function scopePopular($query)
    {
        return $query->orderBy('views', 'desc');
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }

            // Auto-calculate reading time if not provided
            if (empty($blog->reading_time) && $blog->content) {
                $blog->reading_time = self::calculateReadingTime($blog->content);
            }
        });

        static::updating(function ($blog) {
            if ($blog->isDirty('title') && empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }

            // Recalculate reading time if content changed
            if ($blog->isDirty('content') && $blog->content) {
                $blog->reading_time = self::calculateReadingTime($blog->content);
            }
        });
    }

    /**
     * Get the category that owns the blog.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    /**
     * Get the author that owns the blog.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the featured image URL.
     */
    protected function featuredImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->featured_image ? asset($this->featured_image) : null,
        );
    }

    /**
     * Get formatted gallery images.
     */
    protected function formattedGalleryImages(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->gallery_images) {
                    return [];
                }

                return collect($this->gallery_images)->map(function ($image) {
                    return [
                        'url' => $image['url'] ?? '',
                        'alt' => $image['alt'] ?? '',
                    ];
                })->toArray();
            },
        );
    }

    /**
     * Get content with line breaks converted to HTML.
     */
    protected function contentWithBreaks(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->content) {
                    return '';
                }

                return nl2br(e($this->content));
            },
        );
    }

    /**
     * Get excerpt with line breaks converted to HTML.
     */
    protected function excerptWithBreaks(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->excerpt) {
                    return '';
                }

                return nl2br(e($this->excerpt));
            },
        );
    }

    /**
     * Get formatted tags array.
     */
    protected function formattedTags(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->tags) {
                    return [];
                }

                return collect($this->tags)->map(function ($tag) {
                    return [
                        'name' => $tag,
                        'slug' => Str::slug($tag),
                    ];
                })->toArray();
            },
        );
    }

    /**
     * Increment view count.
     */
    public function incrementViews(): void
    {
        $this->increment('views');
    }

    /**
     * Increment like count.
     */
    public function incrementLikes(): void
    {
        $this->increment('likes');
    }

    /**
     * Decrement like count.
     */
    public function decrementLikes(): void
    {
        $this->decrement('likes');
    }

    /**
     * Calculate reading time based on content.
     */
    public static function calculateReadingTime(string $content): int
    {
        $wordCount = str_word_count(strip_tags($content));
        $minutesToRead = round($wordCount / 200); // Average reading speed: 200 words per minute

        return (int) max(1, $minutesToRead);
    }

    /**
     * Get the URL for the blog post.
     */
    public function getUrlAttribute(): string
    {
        return route('blogs.show', $this->slug);
    }

    /**
     * Get related blogs by tags.
     */
    public function getRelatedBlogsByTags(int $limit = 5): \Illuminate\Database\Eloquent\Collection
    {
        if (!$this->tags) {
            return collect();
        }

        return self::where('id', '!=', $this->id)
            ->where('status', true)
            ->where(function ($query) {
                foreach ($this->tags as $tag) {
                    $query->orWhere(function ($q) use ($tag) {
                        $q->whereJsonContains('tags', $tag)
                          ->orWhereRaw("JSON_CONTAINS(tags, ?)", ['"' . $tag . '"'])
                          ->orWhere('tags', 'like', '%"' . $tag . '"%');
                    });
                }
            })
            ->limit($limit)
            ->get();
    }

    /**
     * Get tags as BlogTag models.
     */
    public function getTagModels(): \Illuminate\Database\Eloquent\Collection
    {
        if (!$this->tags) {
            return collect();
        }

        return \App\Models\BlogTag::whereIn('name', $this->tags)->get();
    }

    /**
     * Get tag model by name.
     */
    public function getTagModelByName(string $tagName): ?\App\Models\BlogTag
    {
        return \App\Models\BlogTag::where('name', $tagName)->first();
    }
}
