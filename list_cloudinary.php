<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Storage;

echo "Listing Cloudinary assets (first 10)...\n";

try {
    $files = Storage::disk('public')->listContents('', true);
    $count = 0;
    foreach ($files as $file) {
        if ($count >= 5) break;
        print_r($file);
        $count++;
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
