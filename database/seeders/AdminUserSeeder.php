<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if an admin user already exists to prevent duplicates
        if (!User::where('email', 'admin@admin.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // You can change this password
            ]);

            $this->command->info('Admin user created successfully!');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}
