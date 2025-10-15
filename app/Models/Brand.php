<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Brand extends Model
{
    protected $fillable = [
        'name', // Section title
        'description', // Section description
        'brands_images', // JSON array of brand images
        'status',
    ];

    protected $casts = [
        'brands_images' => 'array',
        'status' => 'boolean',
    ];

    /**
     * Scope a query to only include active brands.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Get formatted brand images.
     */
    protected function formattedBrandsImages(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->brands_images) {
                    return [];
                }

                return collect($this->brands_images)->map(function ($image) {
                    return [
                        'url' => $image['url'] ?? '',
                        'alt' => $image['alt'] ?? '',
                    ];
                })->toArray();
            },
        );
    }
}
