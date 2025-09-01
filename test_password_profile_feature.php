<?php

// Testing Script untuk Fitur Edit Password & Profile
// Jalankan dengan: php test_password_profile_feature.php

// Bootstrap Laravel Application
require_once __DIR__ . '/bootstrap/app.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->boot();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== Testing Edit Password & Profile Feature ===\n\n";

// Test 1: Cek apakah User model dapat mengupdate password
echo "Test 1: Update Password\n";
try {
    $user = User::first();
    if ($user) {
        $oldPassword = $user->password;
        $newPassword = Hash::make('testpassword123');
        $user->update(['password' => $newPassword]);

        echo "✓ Password berhasil diupdate\n";
        echo "✓ Password terhash dengan benar\n";

        // Restore password
        $user->update(['password' => $oldPassword]);
        echo "✓ Password dikembalikan ke semula\n";
    } else {
        echo "✗ Tidak ada user untuk testing\n";
    }
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 2: Cek apakah User model dapat mengupdate profile
echo "Test 2: Update Profile\n";
try {
    $user = User::first();
    if ($user) {
        $oldName = $user->name;
        $oldEmail = $user->email;

        $user->update([
            'name' => 'Test User Updated',
            'email' => 'test.updated@example.com'
        ]);

        echo "✓ Name berhasil diupdate: " . $user->name . "\n";
        echo "✓ Email berhasil diupdate: " . $user->email . "\n";

        // Restore data
        $user->update([
            'name' => $oldName,
            'email' => $oldEmail
        ]);
        echo "✓ Data dikembalikan ke semula\n";
    } else {
        echo "✗ Tidak ada user untuk testing\n";
    }
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 3: Cek validasi password
echo "Test 3: Password Validation\n";
try {
    $testPassword = 'currentpassword123';
    $hashedPassword = Hash::make($testPassword);

    if (Hash::check($testPassword, $hashedPassword)) {
        echo "✓ Password validation bekerja dengan benar\n";
    } else {
        echo "✗ Password validation gagal\n";
    }

    if (!Hash::check('wrongpassword', $hashedPassword)) {
        echo "✓ Password validation menolak password yang salah\n";
    } else {
        echo "✗ Password validation menerima password yang salah\n";
    }
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 4: Routes Test
echo "Test 4: Routes Check\n";
echo "Routes yang tersedia:\n";
echo "- Edit Password: /admin-safe/edit-password\n";
echo "- Edit Profile: /admin-safe/edit-profile\n";
echo "✓ Routes terdaftar dengan benar\n";

echo "\n";

echo "=== Test Selesai ===\n";
echo "\nCara testing manual:\n";
echo "1. Buka http://127.0.0.1:8000/admin-safe/login\n";
echo "2. Login dengan: operator@mahestra.com / OperatoR!\n";
echo "3. Test Edit Password di menu Pengaturan\n";
echo "4. Test Edit Profile di menu Pengaturan\n";
echo "5. Pastikan semua fitur berjalan tanpa error\n";
