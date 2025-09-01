<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mahestra Printing</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-900 antialiased">
    @php
        // Guard supaya tidak undefined meskipun controller belum dipasang
        $hero = $hero ?? null;
        $contact = $contact ?? null;
        $products = $products ?? collect();
        $testimonials = $testimonials ?? collect();
        $companyProfile = $companyProfile ?? (\App\Models\CompanyProfile::first() ?? null);
        $subsidiaries = $subsidiaries ?? collect();

        // Siapkan $companyImageUrl & $services aman
        $companyImageUrl = $companyImageUrl ?? null;
        if (!$companyImageUrl && $companyProfile && $companyProfile->image) {
            $relative = ltrim($companyProfile->image, '/');
            $fullPath = storage_path('app/public/' . $relative);
            if (file_exists($fullPath)) {
                $companyImageUrl = asset('storage/' . $relative);
            }
        }

        $services = $services ?? [];
        if (empty($services) && $companyProfile && $companyProfile->main_services) {
            $services = array_values(
                array_filter(array_map('trim', preg_split("/\r\n|\n|\r/", $companyProfile->main_services))),
            );
        }

        // Helper kecil untuk nomor WA tanpa "+"
        $wa = $contact && $contact->whatsapp ? ltrim($contact->whatsapp, '+') : '';
    @endphp

    {{-- HEADER --}}
    <header class="fixed w-full bg-white/80 backdrop-blur shadow-sm z-50">
        <nav class="container mx-auto flex justify-between items-center px-6 py-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('logo.svg') }}" alt="Mahestra Logo" class="h-10 w-auto">
                <div>
                    <div class="text-xl font-bold text-[#F53003]">Mahestra Printing</div>
                    <span class="text-sm text-gray-600">test Professional Printing Services</span>
                </div>
            </div>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex items-center gap-8">
                <a href="#home"
                    class="nav-link text-gray-700 hover:text-[#F53003] transition-colors font-medium">Home</a>
                <a href="#products"
                    class="nav-link text-gray-700 hover:text-[#F53003] transition-colors font-medium">Produk</a>
                <a href="#subsidiaries"
                    class="nav-link text-gray-700 hover:text-[#F53003] transition-colors font-medium">Anak
                    Perusahaan</a>
                <a href="#testimonials"
                    class="nav-link text-gray-700 hover:text-[#F53003] transition-colors font-medium">Testimoni</a>
                <a href="#contact"
                    class="nav-link text-gray-700 hover:text-[#F53003] transition-colors font-medium">Kontak</a>
            </div>

            {{-- Mobile Menu Button --}}
            <button id="mobile-menu-button" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>

            {{-- Auth Buttons --}}
            <div class="hidden md:flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        {{-- Dashboard link removed - using Home navigation instead --}}
                    @else
                        <a href="{{ url('/login') }}" class="nav-link">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ url('/register') }}" class="btn-primary">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>

        {{-- Mobile Navigation Menu --}}
        <div id="mobile-menu" class="md:hidden hidden bg-white border-t border-gray-200 shadow-lg">
            <div class="container mx-auto px-6 py-4 space-y-4">
                <a href="#home"
                    class="block nav-link text-gray-700 hover:text-[#F53003] transition-colors font-medium py-2">Home</a>
                <a href="#products"
                    class="block nav-link text-gray-700 hover:text-[#F53003] transition-colors font-medium py-2">Produk</a>
                <a href="#subsidiaries"
                    class="block nav-link text-gray-700 hover:text-[#F53003] transition-colors font-medium py-2">Anak
                    Perusahaan</a>
                <a href="#testimonials"
                    class="block nav-link text-gray-700 hover:text-[#F53003] transition-colors font-medium py-2">Testimoni</a>
                <a href="#contact"
                    class="block nav-link text-gray-700 hover:text-[#F53003] transition-colors font-medium py-2">Kontak</a>
                <hr class="border-gray-200">
                @if (Route::has('login'))
                    @auth
                        {{-- Dashboard link removed - using Home navigation instead --}}
                    @else
                        <a href="{{ url('/login') }}"
                            class="block nav-link text-gray-700 hover:text-[#F53003] transition-colors font-medium py-2">Log
                            in</a>
                        @if (Route::has('register'))
                            <a href="{{ url('/register') }}"
                                class="block btn-primary text-center py-2 rounded-lg">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <main class="pt-24">
        {{-- HERO --}}
        <section id="home" class="relative min-h-[90vh] flex items-center justify-center">
            @if (!empty($hero->image))
                <div class="absolute inset-0">
                    <img src="{{ asset('storage/' . $hero->image) }}" alt="Hero background"
                        class="w-full h-full object-cover" />
                    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
                </div>
            @else
                <div class="absolute inset-0 bg-gradient-to-br from-[#FFF1F0] via-[#FFE6E6] to-[#FFFDF5]"></div>
            @endif

            <div class="relative z-10 text-center px-6 max-w-3xl">
                <h1 class="text-3xl sm:text-4xl md:text-6xl font-extrabold text-white leading-tight drop-shadow-lg">
                    {{ $hero->title ?? 'Cetak Cepat, Hasil Berkualitas' }}
                </h1>
                <p class="mt-4 text-base sm:text-lg md:text-xl text-gray-100">
                    {{ $hero->subtitle ?? 'Solusi cetak cepat dan berkualitas untuk kebutuhan promosi, event, dan merchandise.' }}
                </p>
                <div class="mt-8 flex flex-wrap justify-center gap-4">
                    <a href="#products"
                        class="btn-primary bg-[#F53003] hover:bg-[#d62300] text-white px-6 py-3 rounded-xl font-semibold shadow-lg">
                        Lihat Produk
                    </a>
                    <a href="https://wa.me/{{ optional($contact)->whatsapp ? ltrim($contact->whatsapp, '+') : '' }}"
                        class="btn-secondary bg-white/20 border border-white/40 text-white px-6 py-3 rounded-xl font-semibold hover:bg-white/30 backdrop-blur-md">
                        Hubungi via WhatsApp
                    </a>
                </div>
            </div>
        </section>

        {{-- COMPANY PROFILE --}}
        <section class="py-20 bg-gradient-to-br from-[#FFF5F3] via-white to-[#FFFDF5]">
            @if ($companyProfile)
                <div class="container mx-auto px-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                        {{-- Text --}}
                        <div>
                            <span
                                class="inline-block px-3 py-1 text-sm font-medium bg-[#F53003]/10 text-[#F53003] rounded-full mb-4">
                                Tentang Kami
                            </span>
                            <h2 class="text-2xl sm:text-3xl lg:text-5xl font-extrabold text-gray-900 mb-4">
                                {{ $companyProfile->title }}
                            </h2>
                            @if ($companyProfile->subtitle)
                                <h3 class="text-base sm:text-lg lg:text-xl font-semibold text-[#F53003] mb-6">
                                    {{ $companyProfile->subtitle }}
                                </h3>
                            @endif
                            @if ($companyProfile->description)
                                <p class="text-gray-700 leading-relaxed mb-6">
                                    {{ $companyProfile->description }}
                                </p>
                            @endif

                            {{-- Services --}}
                            @if (count($services))
                                <div class="space-y-3">
                                    <h4 class="text-lg font-semibold mb-2">✨ Layanan Utama</h4>
                                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        @foreach ($services as $service)
                                            <li class="flex items-center gap-2 text-gray-700">
                                                <span
                                                    class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-[#F53003]/10 text-[#F53003] text-xs font-bold">✔</span>
                                                {{ $service }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        {{-- Image --}}
                        <div class="flex justify-center relative">
                            @if ($companyImageUrl)
                                <div class="relative group">
                                    <img src="{{ $companyImageUrl }}" alt="Company Image"
                                        class="rounded-2xl shadow-xl w-full max-w-md object-cover group-hover:scale-105 transition duration-500">
                                    <div
                                        class="absolute inset-0 rounded-2xl ring-4 ring-[#F53003]/20 opacity-0 group-hover:opacity-100 transition">
                                    </div>
                                </div>
                            @else
                                <div
                                    class="w-full max-w-md h-64 bg-gray-100 rounded-lg flex items-center justify-center shadow-inner">
                                    <span class="text-gray-500">No image</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </section>

        {{-- PRODUCTS --}}
        <section id="products" class="py-20 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <span
                        class="inline-block px-3 py-1 text-sm font-medium bg-[#F53003]/10 text-[#F53003] rounded-full mb-3">
                        Produk
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Produk Kami</h2>
                    <p class="text-gray-600 mt-2">Kualitas terjamin, harga kompetitif</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($products as $product)
                        <div
                            class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition transform hover:-translate-y-2">
                            <div class="relative h-52 overflow-hidden">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
                                @endif
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition">
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                                <p class="mt-2 text-sm text-gray-600 line-clamp-2">{{ $product->description }}</p>
                                <div class="mt-4 text-2xl text-[#F53003] font-bold">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </div>
                                <div class="mt-6 flex gap-3">
                                    <a href="https://wa.me/{{ optional($contact)->whatsapp ? ltrim($contact->whatsapp, '+') : '' }}"
                                        class="flex-1 bg-[#F53003] hover:bg-[#d62300] text-white py-2 rounded-xl font-medium text-center shadow">
                                        Order
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="col-span-full text-gray-600 text-center">Belum ada produk.</p>
                    @endforelse
                </div>
            </div>
        </section>

        {{-- SUBSIDIARIES --}}
        <section id="subsidiaries" class="py-20 bg-gradient-to-br from-white via-[#FFF5F3] to-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <span
                        class="inline-block px-3 py-1 text-sm font-medium bg-[#F53003]/10 text-[#F53003] rounded-full mb-3">
                        Anak Perusahaan
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Subsidiaries Kami</h2>
                    <p class="text-gray-600 mt-2">Jaringan perusahaan yang mendukung layanan kami</p>
                </div>

                @if ($subsidiaries->count() > 3)
                    {{-- Horizontal Scroll Layout --}}
                    <div class="relative">
                        <div class="flex gap-6 overflow-x-auto pb-4 px-2 scrollbar-hide scroll-smooth"
                            style="scrollbar-width: none; -ms-overflow-style: none;">
                            @foreach ($subsidiaries as $subsidiary)
                                <div
                                    class="flex-none w-80 group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2">
                                    <div class="relative h-48 overflow-hidden">
                                        @if ($subsidiary->image)
                                            <img src="{{ asset('storage/' . $subsidiary->image) }}"
                                                alt="{{ $subsidiary->name }}"
                                                class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
                                        @else
                                            <div
                                                class="w-full h-full bg-gradient-to-br from-[#F53003]/10 to-[#F53003]/20 flex items-center justify-center">
                                                <span class="text-[#F53003] font-semibold">No Image</span>
                                            </div>
                                        @endif
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition">
                                        </div>
                                    </div>
                                    <div class="p-6">
                                        @if ($subsidiary->title)
                                            <span
                                                class="text-sm text-[#F53003] font-medium uppercase tracking-wide">{{ $subsidiary->title }}</span>
                                        @endif
                                        <h3 class="text-xl font-bold text-gray-900 mt-2">{{ $subsidiary->name }}</h3>
                                        @if ($subsidiary->description)
                                            <p class="mt-3 text-gray-600 leading-relaxed">
                                                {{ $subsidiary->description }}</p>
                                        @endif
                                        {{-- Button "Pelajari Lebih Lanjut" removed --}}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Scroll Indicators --}}
                        <div class="flex justify-center mt-6 gap-2">
                            <button onclick="scrollSubsidiaries('left')"
                                class="p-2 bg-white rounded-full shadow-md hover:shadow-lg transition opacity-70 hover:opacity-100">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <button onclick="scrollSubsidiaries('right')"
                                class="p-2 bg-white rounded-full shadow-md hover:shadow-lg transition opacity-70 hover:opacity-100">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @else
                    {{-- Grid Layout for 3 or fewer items --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse($subsidiaries as $subsidiary)
                            <div
                                class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2">
                                <div class="relative h-48 overflow-hidden">
                                    @if ($subsidiary->image)
                                        <img src="{{ asset('storage/' . $subsidiary->image) }}"
                                            alt="{{ $subsidiary->name }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
                                    @else
                                        <div
                                            class="w-full h-full bg-gradient-to-br from-[#F53003]/10 to-[#F53003]/20 flex items-center justify-center">
                                            <span class="text-[#F53003] font-semibold">No Image</span>
                                        </div>
                                    @endif
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition">
                                    </div>
                                </div>
                                <div class="p-6">
                                    @if ($subsidiary->title)
                                        <span
                                            class="text-sm text-[#F53003] font-medium uppercase tracking-wide">{{ $subsidiary->title }}</span>
                                    @endif
                                    <h3 class="text-xl font-bold text-gray-900 mt-2">{{ $subsidiary->name }}</h3>
                                    @if ($subsidiary->description)
                                        <p class="mt-3 text-gray-600 leading-relaxed">{{ $subsidiary->description }}
                                        </p>
                                    @endif
                                    {{-- Button "Pelajari Lebih Lanjut" removed --}}
                                </div>
                            </div>
                        @empty
                            <p class="col-span-full text-gray-600 text-center">Belum ada anak perusahaan.</p>
                        @endforelse
                    </div>
                @endif
            </div>
        </section>

        {{-- TESTIMONIALS --}}
        <section id="testimonials" class="bg-gray-50 py-20">
            <div class="container mx-auto px-6 text-center">
                <span
                    class="inline-block px-3 py-1 text-sm font-medium bg-[#F53003]/10 text-[#F53003] rounded-full mb-3">
                    Testimoni
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold mb-12">Apa Kata Pelanggan</h2>

                @if ($testimonials->count() > 3)
                    {{-- Horizontal Scroll Layout --}}
                    <div class="relative">
                        <div class="flex gap-6 overflow-x-auto pb-4 px-2 scrollbar-hide scroll-smooth"
                            style="scrollbar-width: none; -ms-overflow-style: none;">
                            @foreach ($testimonials as $t)
                                <div
                                    class="flex-none w-80 group bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition relative">
                                    <blockquote class="text-gray-700 italic mb-4">“{{ $t->message }}”</blockquote>
                                    <figcaption class="font-semibold text-gray-900">— {{ $t->name }}</figcaption>
                                    <div class="flex justify-center mt-3 text-yellow-400">
                                        ★★★★☆
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Scroll Indicators --}}
                        <div class="flex justify-center mt-6 gap-2">
                            <button onclick="scrollTestimonials('left')"
                                class="p-2 bg-white rounded-full shadow-md hover:shadow-lg transition opacity-70 hover:opacity-100">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <button onclick="scrollTestimonials('right')"
                                class="p-2 bg-white rounded-full shadow-md hover:shadow-lg transition opacity-70 hover:opacity-100">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @else
                    {{-- Grid Layout for 3 or fewer items --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse($testimonials as $t)
                            <figure class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition relative">
                                <blockquote class="text-gray-700 italic mb-4">“{{ $t->message }}”</blockquote>
                                <figcaption class="font-semibold text-gray-900">— {{ $t->name }}</figcaption>
                                <div class="flex justify-center mt-3 text-yellow-400">
                                    ★★★★☆
                                </div>
                            </figure>
                        @empty
                            <p class="col-span-full text-gray-600">Belum ada testimoni.</p>
                        @endforelse
                    </div>
                @endif
            </div>
        </section>


        {{-- CONTACT --}}
        <section id="contact" class="container mx-auto px-6 py-20">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                <div class="sm:col-span-2 md:col-span-2 bg-white p-8 rounded-2xl shadow">
                    <h2 class="text-xl sm:text-2xl font-bold mb-4">Hubungi Kami</h2>
                    <p class="text-gray-600 mb-6">Kami siap membantu kebutuhan cetak dan merchandise Anda.</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="https://wa.me/{{ $wa }}"
                            class="flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-5 py-3 rounded-xl font-medium shadow">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 .5C5.648.5.5 5.647.5 12c0 2.162.57 4.276 1.654 6.129L.5 23.5l5.56-1.618A11.457 11.457 0 0 0 12 23.5c6.353 0 11.5-5.147 11.5-11.5S18.353.5 12 .5z" />
                            </svg>
                            WhatsApp {{ $contact->whatsapp ?? '-' }}
                        </a>
                        <a href="{{ $contact && $contact->instagram ? 'https://instagram.com/' . ltrim($contact->instagram, '@') : '#' }}"
                            target="_blank"
                            class="flex items-center gap-2 bg-pink-500 hover:bg-pink-600 text-white px-5 py-3 rounded-xl font-medium shadow">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M7.5 2h9A5.5 5.5 0 0 1 22 7.5v9a5.5 5.5 0 0 1-5.5 5.5h-9A5.5 5.5 0 0 1 2 16.5v-9A5.5 5.5 0 0 1 7.5 2z" />
                            </svg>
                            Instagram {{ $contact->instagram ?? '-' }}
                        </a>
                    </div>
                </div>
                <div class="bg-gray-50 p-6 rounded-2xl shadow">
                    <h3 class="font-semibold mb-2 flex items-center gap-2">Alamat</h3>
                    <p class="text-sm text-gray-700">{{ $contact->address ?? '-' }}</p>
                </div>
            </div>
        </section>

    </main>

    {{-- FOOTER --}}
    {{-- FOOTER --}}
    <footer class="bg-gray-900 text-gray-300 py-12 mt-12">
        <div class="container mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            <div>
                <h4 class="text-white font-bold text-lg mb-3">Mahestra Printing</h4>
                <p class="text-sm">Solusi cetak cepat dan berkualitas untuk promosi, event, dan merchandise.</p>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3">Navigasi</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#products" class="hover:text-white">Produk</a></li>
                    <li><a href="#subsidiaries" class="hover:text-white">Anak Perusahaan</a></li>
                    <li><a href="#testimonials" class="hover:text-white">Testimoni</a></li>
                    <li><a href="#contact" class="hover:text-white">Kontak</a></li>
                    <li><a href="#" class="hover:text-white">Tentang</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3">Ikuti Kami</h4>
                <div class="flex gap-4">
                    <a href="https://wa.me/{{ $wa }}" class="hover:text-white">WhatsApp</a>
                    <a href="{{ $contact && $contact->instagram ? 'https://instagram.com/' . ltrim($contact->instagram, '@') : '#' }}"
                        class="hover:text-white">Instagram</a>
                </div>
            </div>
        </div>
        <div class="text-center text-xs text-gray-500 mt-10">
            © {{ date('Y') }} Mahestra Printing — All Rights Reserved
        </div>
    </footer>

    {{-- Custom Styles for Scrollbar and Navigation --}}
    <style>
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        /* Navigation active state */
        .nav-link.active {
            color: #F53003;
            font-weight: 600;
        }

        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }

        /* Mobile menu animation */
        #mobile-menu {
            transition: all 0.3s ease-in-out;
        }

        /* Navigation hover effects */
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 50%;
            background-color: #F53003;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }
    </style>

    {{-- JavaScript for Navigation and Horizontal Scroll --}}
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });

                // Close mobile menu when clicking outside
                document.addEventListener('click', function(event) {
                    if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                        mobileMenu.classList.add('hidden');
                    }
                });

                // Close mobile menu when clicking on a link
                const mobileLinks = mobileMenu.querySelectorAll('a');
                mobileLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        mobileMenu.classList.add('hidden');
                    });
                });
            }

            // Smooth scroll for all navigation links
            const navLinks = document.querySelectorAll('a[href^="#"]');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);

                    if (targetElement) {
                        const headerHeight = document.querySelector('header').offsetHeight;
                        const targetPosition = targetElement.offsetTop - headerHeight - 20;

                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Active navigation state based on scroll position
            function updateActiveNavLink() {
                const sections = document.querySelectorAll('section[id]');
                const navLinks = document.querySelectorAll('a[href^="#"]');
                const headerHeight = document.querySelector('header').offsetHeight;

                let current = '';

                sections.forEach(section => {
                    const sectionTop = section.offsetTop - headerHeight - 100;
                    const sectionHeight = section.clientHeight;
                    if (window.pageYOffset >= sectionTop && window.pageYOffset < sectionTop +
                        sectionHeight) {
                        current = '#' + section.id;
                    }
                });

                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === current) {
                        link.classList.add('active');
                    }
                });
            }

            // Update active nav link on scroll
            window.addEventListener('scroll', updateActiveNavLink);
            updateActiveNavLink(); // Initial call

            // Handle Subsidiaries scroll
            const subsidiariesContainer = document.querySelector('#subsidiaries .overflow-x-auto');
            const subsidiariesButtons = document.querySelectorAll('#subsidiaries button[onclick]');

            if (subsidiariesContainer && subsidiariesButtons.length > 0) {
                function toggleSubsidiariesButtons() {
                    const isMobile = window.innerWidth < 768;
                    subsidiariesButtons.forEach(button => {
                        button.style.display = isMobile ? 'none' : 'flex';
                    });
                }

                toggleSubsidiariesButtons();
                window.addEventListener('resize', toggleSubsidiariesButtons);

                subsidiariesContainer.addEventListener('scroll', function() {
                    const scrollLeft = subsidiariesContainer.scrollLeft;
                    const scrollWidth = subsidiariesContainer.scrollWidth;
                    const clientWidth = subsidiariesContainer.clientWidth;

                    const leftButton = subsidiariesButtons[0];
                    const rightButton = subsidiariesButtons[1];

                    if (leftButton) {
                        leftButton.style.opacity = scrollLeft > 0 ? '1' : '0.5';
                    }
                    if (rightButton) {
                        rightButton.style.opacity = scrollLeft < scrollWidth - clientWidth - 10 ? '1' :
                            '0.5';
                    }
                });

                // Add swipe support for mobile
                let startX = 0;
                let scrollLeftStart = 0;

                subsidiariesContainer.addEventListener('touchstart', (e) => {
                    startX = e.touches[0].pageX;
                    scrollLeftStart = subsidiariesContainer.scrollLeft;
                });

                subsidiariesContainer.addEventListener('touchmove', (e) => {
                    if (!startX) return;
                    const x = e.touches[0].pageX;
                    const walk = (startX - x) * 2; // Scroll speed
                    subsidiariesContainer.scrollLeft = scrollLeftStart + walk;
                });

                subsidiariesContainer.addEventListener('touchend', () => {
                    startX = 0;
                });
            }

            // Handle Testimonials scroll
            const testimonialsContainer = document.querySelector('.bg-gray-50 .overflow-x-auto');
            const testimonialsButtons = document.querySelectorAll('.bg-gray-50 button[onclick]');

            if (testimonialsContainer && testimonialsButtons.length > 0) {
                function toggleTestimonialsButtons() {
                    const isMobile = window.innerWidth < 768;
                    testimonialsButtons.forEach(button => {
                        button.style.display = isMobile ? 'none' : 'flex';
                    });
                }

                toggleTestimonialsButtons();
                window.addEventListener('resize', toggleTestimonialsButtons);

                testimonialsContainer.addEventListener('scroll', function() {
                    const scrollLeft = testimonialsContainer.scrollLeft;
                    const scrollWidth = testimonialsContainer.scrollWidth;
                    const clientWidth = testimonialsContainer.clientWidth;

                    const leftButton = testimonialsButtons[0];
                    const rightButton = testimonialsButtons[1];

                    if (leftButton) {
                        leftButton.style.opacity = scrollLeft > 0 ? '1' : '0.5';
                    }
                    if (rightButton) {
                        rightButton.style.opacity = scrollLeft < scrollWidth - clientWidth - 10 ? '1' :
                            '0.5';
                    }
                });

                // Add swipe support for mobile
                let startX = 0;
                let scrollLeftStart = 0;

                testimonialsContainer.addEventListener('touchstart', (e) => {
                    startX = e.touches[0].pageX;
                    scrollLeftStart = testimonialsContainer.scrollLeft;
                });

                testimonialsContainer.addEventListener('touchmove', (e) => {
                    if (!startX) return;
                    const x = e.touches[0].pageX;
                    const walk = (startX - x) * 2; // Scroll speed
                    testimonialsContainer.scrollLeft = scrollLeftStart + walk;
                });

                testimonialsContainer.addEventListener('touchend', () => {
                    startX = 0;
                });
            }
        });

        function scrollSubsidiaries(direction) {
            const container = document.querySelector('#subsidiaries .overflow-x-auto');
            if (!container) return;

            const scrollAmount = 320; // Width of one card + gap
            const currentScroll = container.scrollLeft;

            if (direction === 'left') {
                container.scrollTo({
                    left: currentScroll - scrollAmount,
                    behavior: 'smooth'
                });
            } else {
                container.scrollTo({
                    left: currentScroll + scrollAmount,
                    behavior: 'smooth'
                });
            }
        }

        function scrollTestimonials(direction) {
            const container = document.querySelector('.bg-gray-50 .overflow-x-auto');
            if (!container) return;

            const scrollAmount = 320; // Width of one testimonial card + gap
            const currentScroll = container.scrollLeft;

            if (direction === 'left') {
                container.scrollTo({
                    left: currentScroll - scrollAmount,
                    behavior: 'smooth'
                });
            } else {
                container.scrollTo({
                    left: currentScroll + scrollAmount,
                    behavior: 'smooth'
                });
            }
        }
    </script>

</body>

</html>
