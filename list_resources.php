<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Filament\Facades\Filament;

$panel = Filament::getPanel('admin');
$resources = $panel->getResources();

echo "Registered Resources for panel 'admin':\n";
foreach ($resources as $resource) {
    echo "- " . $resource . "\n";
}

if (empty($resources)) {
    echo "NO RESOURCES FOUND!\n";
}
