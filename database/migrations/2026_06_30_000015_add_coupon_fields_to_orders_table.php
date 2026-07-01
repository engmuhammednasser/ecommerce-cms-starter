<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('coupon_code')->nullable()->after('payment_method');
            $table->string('coupon_name')->nullable()->after('coupon_code');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('coupon_name');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['coupon_code', 'coupon_name', 'discount_amount']);
        });
    }
};
