<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'customer_id',
    'order_number',
    'customer_name',
    'customer_email',
    'customer_phone',
    'customer_address',
    'notes',
    'admin_notes',
    'status',
    'payment_status',
    'fulfillment_status',
    'payment_method',
    'shipping_zone',
    'shipping_rate_name',
    'coupon_code',
    'coupon_name',
    'discount_amount',
    'subtotal',
    'shipping_amount',
    'tax_amount',
    'total',
])]
class Order extends Model
{
    public const STATUSES = [
        'pending' => 'Pending',
        'processing' => 'Processing',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
        'refunded' => 'Refunded',
    ];

    public const PAYMENT_STATUSES = [
        'unpaid' => 'Unpaid',
        'paid' => 'Paid',
        'failed' => 'Failed',
        'refunded' => 'Refunded',
    ];

    public const FULFILLMENT_STATUSES = [
        'unfulfilled' => 'Unfulfilled',
        'partially_fulfilled' => 'Partially Fulfilled',
        'fulfilled' => 'Fulfilled',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'shipping_amount' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    /**
     * @return BelongsTo<Customer, $this>
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return HasMany<OrderItem, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * @return HasMany<OrderHistory, $this>
     */
    public function histories(): HasMany
    {
        return $this->hasMany(OrderHistory::class);
    }
}
