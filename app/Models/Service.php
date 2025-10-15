<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'title',
        'description',
        'hero_image',
        'process_title',
        'process_description',
        'process_steps',
        'gallery_title',
        'gallery_description',
        'gallery_images',
        'seo_content',
        'status',
    ];

    protected $casts = [
        'process_steps' => 'array',
        'gallery_images' => 'array',
        'status' => 'boolean',
        'seo_content' => 'string',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Scope a query to only include active services.
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

        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->name);
            }
        });

        static::updating(function ($service) {
            if ($service->isDirty('name') && empty($service->slug)) {
                $service->slug = Str::slug($service->name);
            }
        });
    }

    /**
     * Get the hero image URL.
     */
    protected function heroImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->hero_image ? asset($this->hero_image) : null,
        );
    }

    /**
     * Get formatted process steps.
     */
    protected function formattedProcessSteps(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->process_steps) {
                    return [];
                }

                return collect($this->process_steps)->map(function ($step, $index) {
                    return [
                        'step' => $index + 1,
                        'title' => $step['title'] ?? '',
                        'description' => $step['description'] ?? '',
                    ];
                })->toArray();
            },
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
     * Get sanitized SEO content for safe HTML rendering.
     */
    protected function sanitizedSeoContent(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->seo_content) {
                    return '';
                }

                // Allow safe HTML tags for Quill Editor content
                $allowedTags = '<h1><h2><h3><h4><h5><h6><p><br><strong><b><em><i><u><s><ul><ol><li><blockquote><a><img><table><thead><tbody><tr><th><td><div><span><pre><code>';

                return strip_tags($this->seo_content, $allowedTags);
            },
        );
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
}
