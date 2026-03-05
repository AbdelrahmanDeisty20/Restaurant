<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

$role = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
$permissions = Permission::all();

echo "Granting " . $permissions->count() . " permissions to super_admin...\n";
$role->syncPermissions($permissions);

$user = User::where('email', 'admin@admin.com')->first();
if ($user && !$user->hasRole('super_admin')) {
    echo "Assigning super_admin role to user...\n";
    $user->assignRole($role);
}

app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

echo "Done.\n";
