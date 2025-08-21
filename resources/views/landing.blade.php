<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mahestra Printing</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-surface text-gray-900">
    <header class="container mx-auto p-6">
        <nav class="flex justify-between items-center">
            <div class="text-xl font-semibold">Mahestra Printing</div>
            <div>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-4 py-2">Dashboard</a>
                    @else
                        <a href="{{ url('/login') }}" class="px-4 py-2">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ url('/register') }}" class="px-4 py-2">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>
    </header>

    <main class="container mx-auto p-6">
        {{-- Hero --}}
        <section class="mb-16 relative overflow-hidden rounded-lg">
            <div class="absolute inset-0 bg-gradient-to-br from-[#FFF1F0] via-[#FFE6E6] to-[#FFFDF5] opacity-95"></div>
            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-8 items-center p-8 lg:p-16">
                <div>
                    <h1 class="text-4xl lg:text-5xl font-extrabold leading-tight">
                        {{ $hero->title ?? 'Mahestra Printing — Cetak Cepat, Hasil Berkualitas' }}
                    </h1>
                    <p class="mt-4 text-lg text-gray-700 max-w-prose">
                        {{ $hero->subtitle ?? 'Solusi cetak cepat dan berkualitas untuk kebutuhan promosi, event, dan merchandise.' }}
                    </p>

                    <div class="mt-6 flex flex-col sm:flex-row gap-3">
                        <a href="#products"
                            class="inline-block bg-[#F53003] hover:bg-[#d42a02] text-white px-6 py-3 rounded-md shadow-md font-semibold">Lihat
                            Produk</a>
                        <a href="https://wa.me/{{ optional($contact)->whatsapp ? ltrim($contact->whatsapp, '+') : '' }}"
                            class="inline-block bg-white px-6 py-3 rounded-md shadow-sm border border-gray-200 text-gray-800">Hubungi
                            via WhatsApp</a>
                    </div>

                    <div class="mt-6 flex gap-6 items-center text-sm text-gray-600">
                        <div>
                            <div class="text-xs uppercase text-gray-500">Lokasi</div>
                            <div class="font-medium">{{ $contact->address ?? 'Jakarta, Indonesia' }}</div>
                        </div>
                        <div>
                            <div class="text-xs uppercase text-gray-500">Instagram</div>
                            <div class="font-medium">{{ $contact->instagram ?? '@mahestraprint' }}</div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center">
                    @if (!empty($hero->image))
                        <img src="{{ asset('storage/' . $hero->image) }}" alt="Hero image"
                            class="rounded-lg shadow-2xl w-full max-w-lg object-cover" />
                    @else
                        <div
                            class="w-full max-w-lg h-64 lg:h-80 bg-card rounded-lg flex items-center justify-center shadow-lg">
                            <div class="text-gray-600">No hero image — upload via admin</div>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        {{-- Products --}}
        <section id="products" class="mb-16">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-3xl font-bold">Produk Kami</h2>
                <p class="text-sm text-gray-600">Kualitas terjamin, harga kompetitif</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($products as $product)
                    <div class="bg-white rounded-lg p-6 shadow hover:shadow-lg transition">
                        <div class="h-40 bg-card rounded-md flex items-center justify-center mb-4">
                            @if (!empty($product->image))
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover rounded-md" />
                            @else
                                <span class="text-gray-400">Image</span>
                            @endif
                        </div>
                        <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                        <div class="mt-2 text-xl text-[#F53003] font-bold">Rp
                            {{ number_format($product->price, 0, ',', '.') }}</div>
                        @if ($product->description)
                            <p class="text-sm text-gray-600 mt-3">{{ $product->description }}</p>
                        @endif
                        <div class="mt-5 flex gap-3">
                            <a href="https://wa.me/{{ optional($contact)->whatsapp ? ltrim($contact->whatsapp, '+') : '' }}"
                                class="inline-block px-4 py-2 btn-primary">Order via WA</a>
                            <button class="px-4 py-2 border rounded-md">Detail</button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-gray-600">Belum ada produk.</div>
                @endforelse
            </div>
        </section>

        {{-- Contact --}}
        <section class="mb-16">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                <div class="md:col-span-2 bg-white rounded-lg p-6 shadow">
                    <h2 class="text-2xl font-semibold mb-3">Hubungi Kami</h2>
                    <p class="text-gray-600 mb-4">Siap membantu kebutuhan cetak dan merchandise Anda. Kirim pesan via
                        WhatsApp atau kunjungi Instagram kami.</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="https://wa.me/{{ optional($contact)->whatsapp ? ltrim($contact->whatsapp, '+') : '' }}"
                            class="inline-flex items-center gap-3 bg-[#25D366] text-white px-4 py-3 rounded-md shadow">
                            <span class="font-semibold">WhatsApp</span>
                            <span class="text-sm opacity-80">{{ $contact->whatsapp ?? '-' }}</span>
                        </a>
                        <a href="https://instagram.com/{{ optional($contact)->instagram ? ltrim($contact->instagram, '@') : '' }}"
                            target="_blank" class="inline-flex items-center gap-3 bg-white border px-4 py-3 rounded-md">
                            <span class="font-semibold">Instagram</span>
                            <span class="text-sm opacity-80">{{ $contact->instagram ?? '-' }}</span>
                        </a>
                    </div>
                </div>

                <div class="bg-card p-6 rounded-lg shadow">
                    <h3 class="font-semibold mb-2">Alamat</h3>
                    <p class="text-sm text-gray-700">{{ $contact->address ?? '-' }}</p>
                </div>
            </div>
        </section>

        {{-- Testimonials --}}
        <section class="mb-24">
            <h2 class="text-3xl font-bold mb-6">Apa kata pelanggan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($testimonials as $t)
                    <figure class="bg-white p-6 rounded-lg shadow">
                        <blockquote class="text-gray-700">“{{ $t->message }}”</blockquote>
                        <figcaption class="mt-4 text-sm font-medium text-gray-900">— {{ $t->name }}</figcaption>
                    </figure>
                @empty
                    <div class="text-gray-600">Belum ada testimoni.</div>
                @endforelse
            </div>
        </section>
    </main>
</body>

</html>
