<?php

/**
 * Redirect ke folder public jika hosting tidak menggunakan public sebagai document root
 * Letakkan file ini di root directory (satu level di atas folder public)
 */

// Cek apakah sudah di dalam folder public
if (basename(__DIR__) === 'public') {
    // Sudah di public, load Laravel
    require_once __DIR__ . '/index.php';
} else {
    // Belum di public, redirect ke public folder
    $publicPath = __DIR__ . '/public';

    if (file_exists($publicPath . '/index.php')) {
        // Redirect ke public folder
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $uri = $_SERVER['REQUEST_URI'];

        // Hapus trailing slash jika ada
        $uri = rtrim($uri, '/');

        // Redirect ke public
        $redirectUrl = $protocol . '://' . $host . $uri . '/public';

        header('Location: ' . $redirectUrl);
        exit();
    } else {
        die('Laravel application not found. Please check your installation.');
    }
}
