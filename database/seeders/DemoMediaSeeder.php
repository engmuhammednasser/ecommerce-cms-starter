<?php

namespace Database\Seeders;

use App\Models\Media;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DemoMediaSeeder extends Seeder
{
    /**
     * @var array<int, array{file: string, alt: string}>
     */
    private array $assets = [
        ['file' => 'logo.svg', 'alt' => 'Demo store logo'],
        ['file' => 'favicon.svg', 'alt' => 'Demo store favicon'],
        ['file' => 'hero.svg', 'alt' => 'Demo storefront hero'],
        ['file' => 'banner.svg', 'alt' => 'Demo promotional banner'],
        ['file' => 'category-fashion.svg', 'alt' => 'Demo fashion category'],
        ['file' => 'category-home.svg', 'alt' => 'Demo home category'],
        ['file' => 'product-backpack.svg', 'alt' => 'Demo backpack product'],
        ['file' => 'product-lamp.svg', 'alt' => 'Demo lamp product'],
        ['file' => 'product-sneakers.svg', 'alt' => 'Demo sneakers product'],
    ];

    public function run(): void
    {
        foreach ($this->assets as $asset) {
            $source = database_path('demo-media/'.$asset['file']);
            $path = 'demo/'.$asset['file'];

            Storage::disk('public')->put($path, File::get($source));

            Media::query()->updateOrCreate(
                ['disk' => 'public', 'path' => $path],
                [
                    'original_name' => $asset['file'],
                    'file_name' => $asset['file'],
                    'mime_type' => 'image/svg+xml',
                    'size' => Storage::disk('public')->size($path),
                    'type' => 'image',
                    'alt_text' => $asset['alt'],
                ],
            );
        }
    }
}
