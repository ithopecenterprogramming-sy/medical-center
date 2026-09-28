<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@medical-center.com',
            ],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('Admin@123456'),
                'phone' => '+963911111111',
                'gender' => 'male',
                'date_of_birth' => '1988-01-15',
                'address' => 'Main Admin Office',
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}