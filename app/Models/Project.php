<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    protected $fillable = [
        'title',
        'category',
        'image',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Resolve a usable image URL for both seeded assets (public/img/...)
     * and admin-uploaded files (stored on the public disk).
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                if (! $this->image) {
                    return asset('img/portfolio-1.jpg');
                }

                if (str_starts_with($this->image, 'img/') || str_starts_with($this->image, 'http')) {
                    return asset($this->image);
                }

                return Storage::disk('public')->url($this->image);
            }
        );
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
