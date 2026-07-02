<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('main_image_id')->nullable()->constrained('media')->nullOnDelete();
            $table->foreignId('hover_image_id')->nullable()->constrained('media')->nullOnDelete();
            $table->foreignId('seo_image_id')->nullable()->constrained('media')->nullOnDelete();
        });

        if (Schema::hasTable('product_variants')) {
            Schema::table('product_variants', function (Blueprint $table) {
                $table->foreignId('image_id')->nullable()->constrained('media')->nullOnDelete();
            });
        }

        Schema::table('categories', function (Blueprint $table) {
            $table->foreignId('cover_image_id')->nullable()->constrained('media')->nullOnDelete();
            $table->foreignId('icon_image_id')->nullable()->constrained('media')->nullOnDelete();
        });

        Schema::table('page_sections', function (Blueprint $table) {
            $table->foreignId('desktop_image_id')->nullable()->constrained('media')->nullOnDelete();
            $table->foreignId('mobile_image_id')->nullable()->constrained('media')->nullOnDelete();
            $table->foreignId('background_image_id')->nullable()->constrained('media')->nullOnDelete();
            $table->string('image_alt')->nullable();
            $table->string('image_position')->nullable();
            $table->string('overlay_style')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ecommerce_tables', function (Blueprint $table) {
            //
        });
    }
};
