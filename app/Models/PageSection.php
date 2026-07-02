<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'page_id',
    'type',
    'title',
    'subtitle',
    'content',
    'image',
    'button_text',
    'button_url',
    'settings',
    'sort_order',
    'is_active',
])]
class PageSection extends Model
{
    public const TYPES = [
        'hero' => 'Hero',
        'banner' => 'Banner',
        'featured_products' => 'Featured Products',
        'categories_grid' => 'Categories Grid',
        'text_image' => 'Text Image',
        'testimonials' => 'Testimonials',
        'cta' => 'Call To Action',
        'newsletter' => 'Newsletter',
    ];

    protected function casts(): array
    {
        return [
            'settings' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<Page, $this>
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function typeLabel(): string
    {
        return self::TYPES[$this->type] ?? ucfirst(str_replace('_', ' ', $this->type));
    }
}
