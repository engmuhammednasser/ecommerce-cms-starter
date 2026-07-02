<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'category_id',
    'brand_id',
    'name',
    'slug',
    'short_description',
    'description',
    'price',
    'sale_price',
    'sku',
    'stock_quantity',
    'status',
    'featured',
    'seo_title',
    'seo_description',
    'seo_image',
    'main_image_id',
    'hover_image_id',
    'seo_image_id',
])]
class Product extends Model
{
    public const STATUSES = [
        'draft' => 'Draft',
        'published' => 'Published',
        'archived' => 'Archived',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'stock_quantity' => 'integer',
            'featured' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo<Brand, $this>
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * @return HasMany<ProductImage, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    /**
     * @return HasOne<ProductImage, $this>
     */
    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    /**
     * @return HasMany<ProductVariant, $this>
     */
    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)->orderBy('sort_order');
    }

    /**
     * Whether this product has any active variants.
     */
    public function hasVariants(): bool
    {
        return $this->variants()->where('status', 'active')->exists();
    }

    /**
     * @return BelongsTo<Media, $this>
     */
    public function mainImage(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'main_image_id');
    }

    /**
     * @return BelongsTo<Media, $this>
     */
    public function hoverImage(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'hover_image_id');
    }

    /**
     * @return BelongsTo<Media, $this>
     */
    public function seoImage(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'seo_image_id');
    }
}
