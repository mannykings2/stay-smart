<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Storage;

echo "Checking Property Image...\n";
$property = \App\Models\Property::whereNotNull('image_path')->first();
if ($property) {
    $url = Storage::disk('public')->url($property->image_path);
    echo "Property Image Path: {$property->image_path}\n";
    echo "Property Image URL: $url\n";
} else {
    echo "No properties with images found.\n";
}
