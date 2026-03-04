<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Assign Super Admin role to the first user or specific email
        $adminUser = User::where('email', 'admin@admin.com')->first();
        if ($adminUser) {
            $adminUser->assignRole($superAdmin);
        }

        // Assign Admin role to another user if exists
        $ahmed = User::where('email', 'ahmed@example.com')->first();
        if ($ahmed) {
            $ahmed->assignRole($admin);
        }

        // Assign User role to others
        $sara = User::where('email', 'sara@example.com')->first();
        if ($sara) {
            $sara->assignRole($userRole);
        }
    }
}
