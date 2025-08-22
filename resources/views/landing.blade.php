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
                    <span class="text-sm text-gray-600">Professional Printing Services</span>
                </div>
            </div>
            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a>
                    @else
                        <a href="{{ url('/login') }}" class="nav-link">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ url('/register') }}" class="btn-primary">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>
    </header>

    <main class="pt-24">
        {{-- HERO --}}
        <section class="relative min-h-[90vh] flex items-center justify-center">
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
                <h1 class="text-4xl md:text-6xl font-extrabold text-white leading-tight drop-shadow-lg">
                    {{ $hero->title ?? 'Cetak Cepat, Hasil Berkualitas' }}
                </h1>
                <p class="mt-4 text-lg md:text-xl text-gray-100">
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
                            <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-4">
                                {{ $companyProfile->title }}
                            </h2>
                            @if ($companyProfile->subtitle)
                                <h3 class="text-lg lg:text-xl font-semibold text-[#F53003] mb-6">
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
                    <h2 class="text-3xl font-bold text-gray-900">Produk Kami</h2>
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

        {{-- TESTIMONIALS --}}
        <section class="bg-gray-50 py-20">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl font-bold mb-10 text-center">Apa kata pelanggan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @forelse($testimonials as $t)
                        <figure class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                            <blockquote class="text-gray-700 italic">“{{ $t->message }}”</blockquote>
                            <figcaption class="mt-4 font-medium text-gray-900">— {{ $t->name }}</figcaption>
                        </figure>
                    @empty
                        <p class="text-gray-600">Belum ada testimoni.</p>
                    @endforelse
                </div>
            </div>
        </section>

        {{-- CONTACT --}}
        <section class="container mx-auto px-6 py-20">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-2 bg-white p-8 rounded-xl shadow">
                    <h2 class="text-2xl font-semibold mb-4">Hubungi Kami</h2>
                    <p class="text-gray-600 mb-6">Kami siap membantu kebutuhan cetak dan merchandise Anda.</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="https://wa.me/{{ optional($contact)->whatsapp ? ltrim($contact->whatsapp, '+') : '' }}"
                            class="btn-whatsapp">
                            WhatsApp {{ $contact->whatsapp ?? '-' }}
                        </a>
                        <a href="https://instagram.com/{{ optional($contact)->instagram ? ltrim($contact->instagram, '@') : '' }}"
                            target="_blank" class="btn-secondary">
                            Instagram {{ $contact->instagram ?? '-' }}
                        </a>
                    </div>
                </div>
                <div class="bg-gray-50 p-6 rounded-xl shadow">
                    <h3 class="font-semibold mb-2">Alamat</h3>
                    <p class="text-sm text-gray-700">{{ $contact->address ?? '-' }}</p>
                </div>
            </div>
        </section>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#F53003] text-white py-8 mt-12">
        <div class="container mx-auto text-center text-sm">
            © {{ date('Y') }} Mahestra Printing — All Rights Reserved
        </div>
    </footer>
</body>

</html>
