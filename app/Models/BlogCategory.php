<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class BlogCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Get the blogs for the category.
     */
    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'category_id');
    }

    /**
     * Get published blogs for the category.
     */
    public function publishedBlogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'category_id')->where('status', true);
    }

    /**
     * Get description with line breaks converted to HTML.
     */
    protected function descriptionWithBreaks(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->description) {
                    return '';
                }

                return nl2br(e($this->description));
            },
        );
    }

    /**
     * Get blogs count for this category.
     */
    protected function blogsCount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->blogs()->count(),
        );
    }

    /**
     * Get published blogs count for this category.
     */
    protected function publishedBlogsCount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->publishedBlogs()->count(),
        );
    }
}
