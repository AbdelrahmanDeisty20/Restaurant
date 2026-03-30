<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            GovernorateSeeder::class,
            CategorySeeder::class,
            ProductExtraSeeder::class,
            ProductSeeder::class,
            UserSeeder::class,
            AddressSeeder::class,
            DriverSeeder::class,
            OfferSeeder::class,
            OfferProductSeeder::class,
            OrderSeeder::class,
            ReviewSeeder::class,
            FavoriteSeeder::class,
            ContactSeeder::class,
            SettingSeeder::class,
            PageSeeder::class,
            RolesSeeder::class,
            DummyProductSeeder::class ,
        ]);
    }
}
