<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CompanyProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', [HomeController::class, 'index']);
Route::get('/company-profile', [CompanyProfileController::class, 'show'])->name('company-profile');

Route::get('/login', function () {
    return view('auth.login'); // pastikan ada file resources/views/auth/login.blade.php
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/admin-safe'); // arahkan ke dashboard Filament
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
});
