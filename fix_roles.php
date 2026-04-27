<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Spatie\Permission\Models\Role;
use App\Models\User;

echo "Checking roles...\n";

$roles = ['super_admin', 'admin'];
$guard = 'web';

foreach ($roles as $roleName) {
    $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => $guard]);
    echo "Role '{$roleName}' for guard '{$guard}' is ready.\n";
}

$adminUser = User::where('email', 'admin@admin.com')->first();
if ($adminUser) {
    if (!$adminUser->hasRole('super_admin')) {
        echo "Assigning 'super_admin' role to admin@admin.com...\n";
        $adminUser->assignRole('super_admin');
    } else {
        echo "User admin@admin.com already has 'super_admin' role.\n";
    }
} else {
    echo "Warning: User admin@admin.com not found. Please assign roles to your admin user manually.\n";
}

app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

echo "Done. The 'no role named admin' error should be resolved now.\n";
