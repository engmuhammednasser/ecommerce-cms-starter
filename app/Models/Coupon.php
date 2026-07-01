<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'code',
    'name',
    'discount_type',
    'discount_value',
    'minimum_order_amount',
    'usage_limit',
    'used_count',
    'starts_at',
    'ends_at',
    'status',
])]
class Coupon extends Model
{
    public const DISCOUNT_TYPES = [
        'fixed' => 'Fixed amount',
        'percentage' => 'Percentage',
    ];

    public const STATUSES = [
        'active' => 'Active',
        'inactive' => 'Inactive',
    ];

    protected function casts(): array
    {
        return [
            'discount_value' => 'decimal:2',
            'minimum_order_amount' => 'decimal:2',
            'usage_limit' => 'integer',
            'used_count' => 'integer',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }
}
