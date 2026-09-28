<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Run Admin Seeder
        $this->call([
            AdminUserSeeder::class,
        ]);

        // 2. Create Sample Doctor User
        User::updateOrCreate(
            [
                'email' => 'doctor@medical-center.com',
            ],
            [
                'name' => 'Dr. Ahmad Ali',
                'password' => Hash::make('password123'),
                'phone' => '+963922222222',
                'gender' => 'male',
                'date_of_birth' => '1985-05-20',
                'address' => 'Damascus, Syria',
                'role' => 'doctor',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // 3. Create Sample Reception User
        User::updateOrCreate(
            [
                'email' => 'reception@medical-center.com',
            ],
            [
                'name' => 'Sara Mahmoud',
                'password' => Hash::make('password123'),
                'phone' => '+963933333333',
                'gender' => 'female',
                'date_of_birth' => '1995-10-10',
                'address' => 'Damascus, Syria',
                'role' => 'reception',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}