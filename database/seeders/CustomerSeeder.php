<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            ['name' => 'Jordan Lee', 'email' => 'jordan@example.com', 'phone' => '+1 555 0123'],
            ['name' => 'Taylor Morgan', 'email' => 'taylor@example.com', 'phone' => '+1 555 0145'],
        ];

        foreach ($customers as $customer) {
            Customer::query()->updateOrCreate(
                ['email' => $customer['email']],
                $customer + ['status' => 'guest'],
            );
        }
    }
}
