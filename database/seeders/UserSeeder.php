<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator StayHub',
                'phone' => '081234567890',
                'password' => Hash::make('password'),
                'role' => UserRole::Admin,
                'email_verified_at' => now(),
            ]
        );

        // 2. Akun Demo User
        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'User',
                'phone' => '081987654321',
                'password' => Hash::make('password'),
                'role' => UserRole::Customer,
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&auto=format&fit=crop',
                'email_verified_at' => now(),
            ]
        );

        // 3. User contoh tambahan
        User::factory()->count(5)->create();
    }
}
