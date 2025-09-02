<?php
// Debug CSRF dan Session
echo "=== DEBUG SESSION & CSRF ===\n\n";

// Test session
session_start();
echo "Session ID: " . session_id() . "\n";
echo "Session Path: " . session_save_path() . "\n";
echo "Session Status: " . session_status() . "\n\n";

// Test Laravel session jika dalam context Laravel
if (function_exists('csrf_token')) {
    echo "CSRF Token: " . csrf_token() . "\n";
    echo "Session Driver: " . config('session.driver') . "\n";
    echo "Session Lifetime: " . config('session.lifetime') . "\n";
    echo "Session Domain: " . config('session.domain') . "\n";
    echo "Session Secure: " . (config('session.secure') ? 'true' : 'false') . "\n";
    echo "Session Same Site: " . config('session.same_site') . "\n";
} else {
    echo "Not in Laravel context\n";
}

echo "\n=== PHP Session Info ===\n";
echo "session.cookie_lifetime: " . ini_get('session.cookie_lifetime') . "\n";
echo "session.cookie_domain: " . ini_get('session.cookie_domain') . "\n";
echo "session.cookie_secure: " . ini_get('session.cookie_secure') . "\n";
echo "session.cookie_samesite: " . ini_get('session.cookie_samesite') . "\n";