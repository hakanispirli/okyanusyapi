<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class BlogTag extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status',
        'usage_count',
    ];

    protected $casts = [
        'status' => 'boolean',
        'usage_count' => 'integer',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Scope a query to only include active tags.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope a query to order by usage count.
     */
    public function scopePopular($query)
    {
        return $query->orderBy('usage_count', 'desc');
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            if (empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });

        static::updating(function ($tag) {
            if ($tag->isDirty('name') && empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });
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
     * Increment usage count.
     */
    public function incrementUsage(): void
    {
        $this->increment('usage_count');
    }

    /**
     * Decrement usage count.
     */
    public function decrementUsage(): void
    {
        $this->decrement('usage_count');

        // If usage count reaches 0 or below, set to 0
        if ($this->usage_count <= 0) {
            $this->update(['usage_count' => 0]);
        }
    }

    /**
     * Get blogs that use this tag.
     */
    public function getBlogsUsingTag(): array
    {
        return \App\Models\Blog::where(function ($query) {
            $query->whereJsonContains('tags', $this->name)
                  ->orWhereRaw("JSON_CONTAINS(tags, ?)", ['"' . $this->name . '"'])
                  ->orWhere('tags', 'like', '%"' . $this->name . '"%');
        })->get()->toArray();
    }

    /**
     * Check if tag is being used by any blog.
     */
    public function isInUse(): bool
    {
        return \App\Models\Blog::where(function ($query) {
            $query->whereJsonContains('tags', $this->name)
                  ->orWhereRaw("JSON_CONTAINS(tags, ?)", ['"' . $this->name . '"'])
                  ->orWhere('tags', 'like', '%"' . $this->name . '"%');
        })->exists();
    }
}
