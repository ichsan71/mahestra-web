<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\CompanyProfile;
use Illuminate\Support\Facades\Storage;

$profile = CompanyProfile::first();

echo "Profile data:\n";
echo "ID: " . ($profile->id ?? 'Not found') . "\n";
echo "Title: " . ($profile->title ?? 'Not found') . "\n";
echo "Image path in DB: " . ($profile->image ?? 'Not found') . "\n";

if ($profile && $profile->image) {
    $fullImagePath = storage_path('app/public/' . $profile->image);
    echo "\nChecking image file:\n";
    echo "Full image path: " . $fullImagePath . "\n";
    echo "File exists: " . (file_exists($fullImagePath) ? 'Yes' : 'No') . "\n";

    echo "\nStorage info:\n";
    echo "Storage::exists('public/' . \$profile->image): " . (Storage::exists('public/' . $profile->image) ? 'Yes' : 'No') . "\n";
    echo "Storage::exists(\$profile->image): " . (Storage::exists($profile->image) ? 'Yes' : 'No') . "\n";

    echo "\nPublic symlink check:\n";
    $publicLinkPath = public_path('storage');
    echo "Public storage symlink exists: " . (is_link($publicLinkPath) ? 'Yes' : 'No') . "\n";

    if (is_link($publicLinkPath)) {
        echo "Symlink target: " . readlink($publicLinkPath) . "\n";
        echo "Target exists: " . (file_exists(readlink($publicLinkPath)) ? 'Yes' : 'No') . "\n";
    }

    $publicImagePath = public_path('storage/' . $profile->image);
    echo "Public image path: " . $publicImagePath . "\n";
    echo "Public image exists: " . (file_exists($publicImagePath) ? 'Yes' : 'No') . "\n";
}
