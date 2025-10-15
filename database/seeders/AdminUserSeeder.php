<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin user already exists
        if (User::where('email', 'admin@okyanusyapi.com')->exists()) {
            $this->command->info('Admin user already exists.');
            return;
        }

        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@okyanusyapi.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@okyanusyapi.com');
        $this->command->info('Password: password');
        $this->command->warn('Please change the password after first login!');
    }
}
