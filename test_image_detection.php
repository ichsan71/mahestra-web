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
    $imagePath = $profile->image;
    $fullPath = storage_path('app/public/' . $imagePath);

    echo "\nTesting our new image detection logic:\n";

    // Check for the file with original extension
    $imageExists = file_exists($fullPath);
    echo "Original file exists: " . ($imageExists ? 'Yes' : 'No') . "\n";

    // If not found, try different extensions
    if (!$imageExists) {
        $pathInfo = pathinfo($fullPath);
        $basePath = $pathInfo['dirname'] . '/' . $pathInfo['filename'];
        $foundExt = null;

        foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
            echo "Checking for extension: $ext - ";
            $testPath = $basePath . '.' . $ext;
            if (file_exists($testPath)) {
                echo "FOUND!\n";
                $foundExt = $ext;
                $imagePath = pathinfo($profile->image, PATHINFO_DIRNAME) . '/' . pathinfo($profile->image, PATHINFO_FILENAME) . '.' . $ext;
                $imageExists = true;
                break;
            } else {
                echo "not found\n";
            }
        }

        if ($foundExt) {
            echo "\nFound image with extension: $foundExt\n";
            echo "Modified path: $imagePath\n";
        }
    }

    echo "\nImage exists: " . ($imageExists ? 'Yes' : 'No') . "\n";
    if ($imageExists) {
        echo "Path to use in view: storage/" . $imagePath . "\n";
    }
}
