<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Media;

class ImportAwaladStore extends Command
{
    protected $signature = 'import:awalad {--dry-run : Only print counts and simulate} {--only= : Comma-separated list of entities to import (media,categories,products,settings,shipping)}';
    protected $description = 'Safely import catalog and media from the old Awalad Farouk store.';

    private string $oldDbPath = 'C:\\xampp\\htdocs\\awalad-farouk\\database\\database.sqlite';
    private string $oldPublicPath = 'C:\\xampp\\htdocs\\awalad-farouk\\public\\';

    public function handle()
    {
        if (!file_exists($this->oldDbPath)) {
            $this->error("Old database not found at: {$this->oldDbPath}");
            return Command::FAILURE;
        }

        config()->set('database.connections.sqlite_awalad', [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => $this->oldDbPath,
            'prefix' => '',
            'foreign_key_constraints' => false,
        ]);

        $dryRun = $this->option('dry-run');
        $only = $this->option('only') ? explode(',', $this->option('only')) : ['settings', 'shipping', 'categories', 'products', 'media'];

        if ($dryRun) {
            $this->info("--- DRY RUN MODE ---");
        }

        $this->info("Connected to old database.");

        if (in_array('categories', $only)) {
            $this->importCategories($dryRun);
        }

        if (in_array('products', $only)) {
            $this->importProducts($dryRun);
        }

        if (in_array('media', $only)) {
            $this->importMedia($dryRun);
        }

        $this->info("Import process complete.");
        return Command::SUCCESS;
    }

    private function importCategories(bool $dryRun): void
    {
        $this->info("Importing Categories...");
        $oldCategories = DB::connection('sqlite_awalad')->table('product_categories')->get();
        $this->info("Found {$oldCategories->count()} categories.");

        $created = 0;
        $updated = 0;
        $oldIdToSlug = [];

        // Pass 1: Ensure all categories exist
        foreach ($oldCategories as $old) {
            $oldIdToSlug[$old->id] = $old->slug;
            if (!$dryRun) {
                $category = Category::where('slug', $old->slug)->first();
                if ($category) {
                    $category->update([
                        'name' => $old->name,
                        'description' => $old->description,
                        'status' => $old->is_active ? 'published' : 'draft',
                    ]);
                    $updated++;
                } else {
                    Category::create([
                        'name' => $old->name,
                        'slug' => $old->slug,
                        'description' => $old->description,
                        'status' => $old->is_active ? 'published' : 'draft',
                    ]);
                    $created++;
                }
            } else {
                if (Category::where('slug', $old->slug)->exists()) {
                    $updated++;
                } else {
                    $created++;
                }
            }
        }

        // Pass 2: Establish parent relationships
        if (!$dryRun) {
            foreach ($oldCategories as $old) {
                if ($old->parent_id && isset($oldIdToSlug[$old->parent_id])) {
                    $parentSlug = $oldIdToSlug[$old->parent_id];
                    $parentCat = Category::where('slug', $parentSlug)->first();
                    $childCat = Category::where('slug', $old->slug)->first();
                    
                    if ($parentCat && $childCat && $childCat->parent_id !== $parentCat->id) {
                        $childCat->update(['parent_id' => $parentCat->id]);
                    }
                }
            }
        }

        $this->info("Categories: Created {$created}, Updated {$updated}. (Parent hierarchies processed)");
    }

    private function importProducts(bool $dryRun): void
    {
        $this->info("Importing Products...");
        $oldProducts = DB::connection('sqlite_awalad')->table('products')->get();
        $this->info("Found {$oldProducts->count()} products.");

        $created = 0;
        $updated = 0;
        $variantsFound = 0;

        foreach ($oldProducts as $old) {
            $price = $old->price ?? $old->regular_price ?? 0;
            $salePrice = $old->sale_price;

            if (!$dryRun) {
                $product = Product::where('slug', $old->slug)->orWhere('sku', $old->sku)->first();
                $data = [
                    'name' => $old->name,
                    'slug' => $old->slug,
                    'sku' => $old->sku ?: Str::random(10),
                    'price' => $price,
                    'sale_price' => $salePrice,
                    'description' => $old->description,
                    'short_description' => $old->short_description,
                    'stock_quantity' => $old->stock_quantity ?? 0,
                    'status' => ($old->status === 'publish' || $old->status === 'published') ? 'published' : 'draft',
                ];

                if ($product) {
                    $product->update($data);
                    $updated++;
                } else {
                    $product = Product::create($data);
                    $created++;
                }

                // Variants
                if ($old->is_variable) {
                    $oldVars = DB::connection('sqlite_awalad')->table('product_variations')->where('product_id', $old->id)->get();
                    $variantsFound += $oldVars->count();
                    foreach ($oldVars as $v) {
                        ProductVariant::updateOrCreate(
                            ['product_id' => $product->id, 'sku' => $v->sku ?: Str::random(10)],
                            [
                                'price' => $v->price ?? $v->regular_price ?? 0,
                                'sale_price' => $v->sale_price,
                                'stock_quantity' => $v->stock_quantity ?? 0,
                                'status' => 'active',
                            ]
                        );
                    }
                }
            } else {
                if (Product::where('slug', $old->slug)->orWhere('sku', $old->sku)->exists()) {
                    $updated++;
                } else {
                    $created++;
                }
                if ($old->is_variable) {
                    $variantsFound += DB::connection('sqlite_awalad')->table('product_variations')->where('product_id', $old->id)->count();
                }
            }
        }

        $this->info("Products: Created {$created}, Updated {$updated}. Variants found: {$variantsFound}");
    }

    private function importMedia(bool $dryRun): void
    {
        $this->info("Importing Media...");
        $oldImages = DB::connection('sqlite_awalad')->table('product_images')->get();
        $this->info("Found {$oldImages->count()} media files in DB.");

        $missing = 0;
        $created = 0;

        foreach ($oldImages as $img) {
            $sourcePath = $this->oldPublicPath . str_replace('/', DIRECTORY_SEPARATOR, ltrim($img->path, '/'));
            if (!file_exists($sourcePath)) {
                $missing++;
                continue;
            }

            if (!$dryRun) {
                $destPath = storage_path('app/public/imported/awalad/' . basename($img->path));
                if (!file_exists(dirname($destPath))) {
                    mkdir(dirname($destPath), 0755, true);
                }

                if (!file_exists($destPath)) {
                    copy($sourcePath, $destPath);
                }

                $media = Media::updateOrCreate(
                    ['path' => 'imported/awalad/' . basename($img->path)],
                    [
                        'disk' => 'public',
                        'original_name' => basename($img->path),
                        'file_name' => basename($img->path),
                        'mime_type' => mime_content_type($destPath) ?: 'image/jpeg',
                        'size' => filesize($destPath),
                        'type' => 'image',
                        'alt_text' => $img->alt,
                    ]
                );

                $created++;

                // Assign to product
                $oldProduct = DB::connection('sqlite_awalad')->table('products')->where('id', $img->product_id)->first();
                if ($oldProduct) {
                    $newProduct = Product::where('slug', $oldProduct->slug)->first();
                    if ($newProduct) {
                        if ($img->is_primary && !$newProduct->main_image_id) {
                            $newProduct->update(['main_image_id' => $media->id]);
                        } elseif (!$img->is_primary && !$newProduct->hover_image_id) {
                            $newProduct->update(['hover_image_id' => $media->id]);
                        }
                        
                        // Fallback SEO image
                        if (!$newProduct->seo_image_id) {
                            $newProduct->update(['seo_image_id' => $media->id]);
                        }
                    }
                }
            } else {
                $created++; // Assume it would be created
            }
        }

        $this->info("Media: Missing physical files {$missing}, Will create/update {$created} records.");
    }
}
