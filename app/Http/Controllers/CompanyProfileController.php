<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use Illuminate\Http\Request;

class CompanyProfileController extends Controller
{
    public function show()
    {
        $profile = CompanyProfile::first();
        return view('company-profile', compact('profile'));
    }
}
