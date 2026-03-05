<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Spatie\Permission\Models\Role;
use App\Models\User;

echo "Roles in database:\n";
foreach (Role::all() as $role) {
    echo "ID: {$role->id}, Name: {$role->name}, Guard: {$role->guard_name}\n";
}

$user = User::where('email', 'admin@admin.com')->first();
echo "\nUser Roles:\n";
foreach ($user->roles as $role) {
    echo "Name: {$role->name}, Guard: {$role->guard_name}\n";
}

echo "\nAuth default guard: " . config('auth.defaults.guard') . "\n";
