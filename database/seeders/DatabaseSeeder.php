<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\HeroSection;
use App\Models\Product;
use App\Models\Contact;
use App\Models\Testimonial;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Only create test user if it doesn't exist
        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        // Create hero section if it doesn't exist
        if (!HeroSection::exists()) {
            HeroSection::create([
                'title' => 'Mahestra Printing — Cetak Cepat, Hasil Berkualitas',
                'subtitle' => 'Kami menyediakan solusi cetak untuk brosur, kaos, dan merchandise lainnya dengan layanan cepat dan harga terjangkau.',
                'image' => null,
                'is_published' => true,
            ]);
        }

        // Create products if they don't exist
        if (!Product::exists()) {
            Product::create(['name' => 'Cetak Brosur A4 - 1.000 pcs', 'price' => 450000, 'description' => 'Cetak brosur satu sisi - kertas 150gsm', 'is_published' => true]);
            Product::create(['name' => 'Sablon Kaos 1 warna', 'price' => 30000, 'description' => 'Sablon manual untuk kaos katun', 'is_published' => true]);
        }

        // Create contact if it doesn't exist
        if (!Contact::exists()) {
            Contact::create(['whatsapp' => '+6281234567890', 'instagram' => '@mahestraprint', 'address' => 'Jl. Contoh No. 123, Jakarta']);
        }

        // Create testimonials if they don't exist
        if (!Testimonial::exists()) {
            Testimonial::create(['name' => 'Budi', 'message' => 'Pelayanan cepat dan hasil memuaskan!', 'is_published' => true]);
            Testimonial::create(['name' => 'Siti', 'message' => 'Harga terjangkau, kualitas OK.', 'is_published' => true]);
        }
    }
}
