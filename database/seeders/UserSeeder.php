<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'full_name' => 'Ahmed Mohamed',
                'email' => 'ahmed@example.com',
                'password' => Hash::make('password'),
                'phone' => '01012345678',
                'is_active' => true,
            ],
            [
                'full_name' => 'Sara Ibrahim',
                'email' => 'sara@example.com',
                'password' => Hash::make('password'),
                'phone' => '01122334455',
                'is_active' => true,
            ],
            [
                'full_name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'phone' => '01234567890',
                'is_active' => true,
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(['email' => $userData['email']], $userData);
        }
    }
}
