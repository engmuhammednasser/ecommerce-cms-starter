<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Product;

class CleanAwaladCatalog extends Command
{
    protected $signature = 'catalog:clean-awalad {--dry-run : Only print what would be done}';
    protected $description = 'Clean imported Awalad catalog and assign category visuals.';

    public function handle()
    {
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->info("--- DRY RUN MODE ---");
        }

        $oldDbPath = 'C:\\xampp\\htdocs\\awalad-farouk\\database\\database.sqlite';
        if (file_exists($oldDbPath)) {
            config()->set('database.connections.sqlite_awalad', [
                'driver' => 'sqlite',
                'url' => env('DATABASE_URL'),
                'database' => $oldDbPath,
                'prefix' => '',
                'foreign_key_constraints' => false,
            ]);
        }

        $this->info("Starting Catalog Cleanup Audit...");

        // 1. Audit imported categories
        $topLevelCategories = Category::whereNull('parent_id')->get();
        $childCategories = Category::whereNotNull('parent_id')->get();
        
        $categoriesWithoutProducts = Category::doesntHave('products')->count();
        $topLevelWithoutCover = Category::whereNull('parent_id')->whereNull('cover_image_id')->get();
        
        // Find duplicate slugs (ignoring id)
        $duplicateSlugs = DB::table('categories')
            ->select('slug', DB::raw('COUNT(*) as count'))
            ->groupBy('slug')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        $this->info(sprintf(
            "Categories: %d Top-Level, %d Children, %d without Products, %d top-level without cover image. %d duplicate slugs.",
            $topLevelCategories->count(),
            $childCategories->count(),
            $categoriesWithoutProducts,
            $topLevelWithoutCover->count(),
            $duplicateSlugs->count()
        ));

        // 2. Assign category visuals
        $assignedCovers = 0;
        foreach ($topLevelWithoutCover as $category) {
            // Find a product that belongs to this category or its children
            $categoryIds = Category::where('parent_id', $category->id)->pluck('id')->push($category->id)->toArray();
            
            $productWithImage = Product::whereIn('category_id', $categoryIds)
                ->whereNotNull('main_image_id')
                ->first();

            // If still null, we check if we can query the old Awalad DB's pivot table directly for a fallback mapping
            if (!$productWithImage) {
                try {
                    $oldPivots = DB::connection('sqlite_awalad')->table('product_product_category')
                        ->where('product_category_id', $category->id)
                        ->pluck('product_id')->toArray();
                    
                    if (!empty($oldPivots)) {
                        $productWithImage = Product::whereIn('id', $oldPivots)->whereNotNull('main_image_id')->first();
                    }
                } catch (\Exception $e) {
                    // Ignore if sqlite_awalad isn't configured
                }
            }

            if ($productWithImage && $productWithImage->main_image_id) {
                if (!$dryRun) {
                    $category->update(['cover_image_id' => $productWithImage->main_image_id]);
                }
                $assignedCovers++;
            }
        }
        
        $this->info("Category Visuals: Assigned cover images to {$assignedCovers} top-level categories.");

        // 3. Product cleanup audit
        $productsWithoutMainImage = Product::whereNull('main_image_id')->count();
        $productsWithoutPrice = Product::whereNull('price')->orWhere('price', '<=', 0)->count();
        $productsWithoutCategoryId = Product::whereNull('category_id')->count();

        $this->info(sprintf(
            "Products: %d without main image, %d without valid price, %d missing category_id.",
            $productsWithoutMainImage,
            $productsWithoutPrice,
            $productsWithoutCategoryId
        ));

        // Attempt to heal category_id from old pivot table if running real mode
        $healedCategoryIds = 0;
        if ($productsWithoutCategoryId > 0) {
            try {
                $productsToHeal = Product::whereNull('category_id')->get();
                foreach ($productsToHeal as $product) {
                    $pivot = DB::connection('sqlite_awalad')->table('product_product_category')
                        ->where('product_id', $product->id)
                        ->first();
                        
                    if ($pivot) {
                        if (!$dryRun) {
                            $product->update(['category_id' => $pivot->product_category_id]);
                        }
                        $healedCategoryIds++;
                    }
                }
                $this->info("Healed missing category_id for {$healedCategoryIds} products using old pivot mappings.");
            } catch (\Exception $e) {
                // Ignore if sqlite_awalad isn't configured
            }
        }

        $this->info("Catalog cleanup complete.");
        return Command::SUCCESS;
    }
}
