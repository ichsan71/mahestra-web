<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CompanyProfileController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/company-profile', [CompanyProfileController::class, 'show'])->name('company-profile');
