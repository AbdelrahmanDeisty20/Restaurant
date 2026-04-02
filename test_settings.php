<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Setting;

echo "Settings from Database via Model:\n";
$settings = Setting::all(['key', 'value', 'type']);
foreach ($settings as $setting) {
    echo "- [{$setting->key}]: {$setting->value} ({$setting->type})\n";
}

echo "\nPlucked settings (used by API):\n";
print_r(Setting::pluck('value', 'key')->all());
