<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('email', '!=', 'admin@admin.com')->get();

        foreach ($users as $user) {
            Address::create([
                'user_id' => $user->id,
                'title' => 'Home',
                'address' => '123 Restaurant St, New Cairo, Egypt',
                'is_default' => true,
            ]);

            Address::create([
                'user_id' => $user->id,
                'title' => 'Work',
                'address' => 'Greens Building, Floor 2, Maadi, Cairo',
                'is_default' => false,
            ]);
        }
    }
}
