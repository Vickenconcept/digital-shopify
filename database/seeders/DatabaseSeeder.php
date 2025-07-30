<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);

        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
        $admin->assignRole('super-admin');

        // Create content creator user
        $creator = User::factory()->create([
            'name' => 'Content Creator',
            'email' => 'creator@example.com',
        ]);
        $creator->assignRole('content-creator');

        // Create customer user
        $customer = User::factory()->create([
            'name' => 'Test Customer',
            'email' => 'customer@example.com',
        ]);
        $customer->assignRole('customer');
    }
}
