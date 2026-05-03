<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Storage;
use CodebarAg\FlysystemCloudinary\FlysystemCloudinaryAdapter;
use Cloudinary\Cloudinary;

echo "Testing URL generation difference...\n";

$path = 'apartments/6HLf5yXIcDRkVvWkoVP6MB2lfJK68PdQWZ8XwghK.jpg';

// My optimized URL (currently registered)
$myUrl = Storage::disk('public')->url($path);
echo "My optimized URL: $myUrl\n";

// Original driver's URL (we need to instantiate it manually to bypass my override)
$config = config('filesystems.disks.public');
$cloudinary = new Cloudinary($config);
$originalAdapter = new FlysystemCloudinaryAdapter($cloudinary);
$originalUrl = $originalAdapter->getUrl($path);
echo "Original driver URL: ".($originalUrl ?: 'FALSE')."\n";

if ($myUrl === $originalUrl || str_contains($originalUrl, $myUrl)) {
    echo "SUCCESS: Optimized URL matches or is compatible with original.\n";
} else {
    echo "FAILURE: They still differ significantly!\n";
}
