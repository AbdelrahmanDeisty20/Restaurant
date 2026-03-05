<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Gate;

$user = User::where('email', 'admin@admin.com')->first();

if (!$user) {
    echo "User admin@admin.com not found!\n";
    exit;
}

auth()->login($user);

echo "User ID: " . $user->id . "\n";
echo "Roles: " . $user->getRoleNames()->implode(', ') . "\n";
echo "Gate allows viewAny on Product: " . (Gate::allows('viewAny', Product::class) ? 'YES' : 'NO') . "\n";
echo "Gate check ViewAny:Product permission: " . (Gate::check('ViewAny:Product') ? 'YES' : 'NO') . "\n";
echo "User can ViewAny:Product: " . ($user->can('ViewAny:Product') ? 'YES' : 'NO') . "\n";

// Check if AuthServiceProvider or AppServiceProvider Gate::before is working
Gate::before(function ($user, $ability) {
    // This is already in AppServiceProvider, but let's test it here too if it fails
});
