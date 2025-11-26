<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@tokobuku.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create demo user
        User::create([
            'name' => 'Demo User',
            'username' => 'demouser',
            'email' => 'user@tokobuku.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);
    }
}
