<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'icon',
        'title',
        'description',
        'content_json',
        'excerpt',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Short plain-text summary for cards. Falls back to a stripped,
     * truncated version of the rich description when no excerpt is set.
     */
    protected function cardText(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                if (! empty($this->excerpt)) {
                    return $this->excerpt;
                }

                return Str::limit(trim(strip_tags((string) $this->description)), 120);
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
