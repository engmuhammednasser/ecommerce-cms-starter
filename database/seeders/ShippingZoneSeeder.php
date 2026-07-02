<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zone = \App\Models\ShippingZone::firstOrCreate([
            'name' => 'Rest of World',
        ], [
            'is_active' => true,
            'sort_order' => 0,
        ]);

        $zone->rates()->firstOrCreate([
            'name' => 'Standard Shipping',
        ], [
            'rate' => max(0, (float) setting('shipping.flat_rate', 0)),
            'free_shipping_threshold' => setting('shipping.free_shipping_threshold') !== null ? max(0, (float) setting('shipping.free_shipping_threshold')) : null,
            'is_active' => true,
            'sort_order' => 0,
        ]);
    }
}
