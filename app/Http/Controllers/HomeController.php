<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use App\Models\Product;
use App\Models\Contact;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $hero = HeroSection::where('is_published', true)->latest()->first();
        $products = Product::where('is_published', true)->get();
        $contact = Contact::latest()->first();
        $testimonials = Testimonial::where('is_published', true)->get();

        return view('landing', compact('hero', 'products', 'contact', 'testimonials'));
    }
}
