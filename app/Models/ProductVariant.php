<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable([
    'product_id',
    'sku',
    'price',
    'sale_price',
    'stock_quantity',
    'image',
    'status',
    'sort_order',
])]
class ProductVariant extends Model
{
    public const STATUSES = [
        'active' => 'Active',
        'inactive' => 'Inactive',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'stock_quantity' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<Product, $this>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsToMany<AttributeValue, $this>
     */
    public function attributeValues(): BelongsToMany
    {
        return $this->belongsToMany(
            AttributeValue::class,
            'product_variant_attribute_values',
            'product_variant_id',
            'attribute_value_id'
        );
    }

    /**
     * Effective price: variant price overrides product price. Sale price overrides price.
     */
    public function effectivePrice(Product $product): float
    {
        $base = $this->price !== null ? (float) $this->price : (float) $product->price;
        $sale = $this->sale_price !== null ? (float) $this->sale_price : null;

        if ($sale !== null && $product->sale_price !== null) {
            $sale = min($sale, (float) $product->sale_price);
        }

        return $sale ?? $base;
    }

    /**
     * Generate a human-readable label like "Size: M, Color: Red"
     */
    public function label(): string
    {
        $label = $this->attributeValues
            ->map(fn ($av) => $av->attribute?->name . ': ' . $av->value)
            ->implode(', ');

        return $label ?: 'Variant #' . $this->id;
    }
}
