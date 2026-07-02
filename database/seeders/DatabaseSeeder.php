<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            AdminUserSeeder::class,
            ShippingZoneSeeder::class,
            SettingSeeder::class,
            EmailTemplateSeeder::class,
            DemoMediaSeeder::class,
            PageSeeder::class,
            CategorySeeder::class,
            SectionSeeder::class,
            ProductSeeder::class,
            MenuSeeder::class,
            CustomerSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
