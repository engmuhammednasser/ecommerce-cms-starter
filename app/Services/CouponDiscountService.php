<?php

namespace App\Services;

use App\Models\Coupon;
use Illuminate\Support\Str;

class CouponDiscountService
{
    /**
     * @return array{valid: bool, message: string|null, coupon: Coupon|null, discount: float}
     */
    public function validateCode(?string $code, float $subtotal): array
    {
        $code = Str::upper(trim((string) $code));

        if ($code === '') {
            return $this->invalid('Enter a coupon code.');
        }

        $coupon = Coupon::query()
            ->where('code', $code)
            ->first();

        if (! $coupon) {
            return $this->invalid('Coupon code was not found.');
        }

        if ($coupon->status !== 'active') {
            return $this->invalid('This coupon is not active.');
        }

        if ($coupon->starts_at && now()->lt($coupon->starts_at)) {
            return $this->invalid('This coupon is not active yet.');
        }

        if ($coupon->ends_at && now()->gt($coupon->ends_at)) {
            return $this->invalid('This coupon has expired.');
        }

        if ($coupon->usage_limit !== null && $coupon->used_count >= $coupon->usage_limit) {
            return $this->invalid('This coupon has reached its usage limit.');
        }

        if ($subtotal < (float) $coupon->minimum_order_amount) {
            return $this->invalid('This coupon requires a higher order subtotal.');
        }

        return [
            'valid' => true,
            'message' => null,
            'coupon' => $coupon,
            'discount' => $this->discountAmount($coupon, $subtotal),
        ];
    }

    /**
     * @return array{valid: bool, message: string, coupon: null, discount: float}
     */
    private function invalid(string $message): array
    {
        return [
            'valid' => false,
            'message' => $message,
            'coupon' => null,
            'discount' => 0.0,
        ];
    }

    private function discountAmount(Coupon $coupon, float $subtotal): float
    {
        $value = max(0, (float) $coupon->discount_value);

        if ($coupon->discount_type === 'percentage') {
            $value = $subtotal * (min($value, 100) / 100);
        }

        return round(min($value, $subtotal), 2);
    }
}
