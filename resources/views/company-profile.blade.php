@extends('layouts.app')

@section('content')
    <!-- Hero Section with Company Profile -->
    <section class="relative py-20 bg-gradient-to-br from-white via-slate-50 to-indigo-50 overflow-hidden">
        <!-- Background decoration -->
        <div class="absolute inset-0 bg-grid-slate-100 [mask-image:linear-gradient(0deg,white,rgba(255,255,255,0.6))] -z-10">
        </div>

        <div class="container mx-auto px-6 relative">
            <!-- Company Logo and Header -->
            <div class="text-center mb-16">
                <div class="flex justify-center items-center gap-4 mb-6">
                    <img src="{{ asset('logo-mahestra.svg') }}" alt="Mahestra Logo" class="h-16 w-auto">
                    <div class="text-left">
                        <h1 class="text-3xl font-bold text-slate-900">Mahestra Printing</h1>
                        <p class="text-sm text-slate-600">Professional Printing Services</p>
                    </div>
                </div>

                <span
                    class="inline-block bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-sm font-medium px-4 py-2 rounded-full shadow-lg">
                    Company Profile
                </span>
            </div>

            <!-- Main Content -->
            <div class="max-w-7xl mx-auto">
                <div class="bg-white/80 backdrop-blur-sm shadow-2xl rounded-3xl overflow-hidden border border-white/20">
                    <div class="lg:grid lg:grid-cols-2 lg:gap-0">
                        <!-- Content Section -->
                        <div class="p-8 lg:p-16 flex flex-col justify-center">
                            <div class="space-y-6">
                                <div>
                                    <h2 class="text-4xl lg:text-5xl font-extrabold text-slate-900 leading-tight mb-4">
                                        {{ $profile->title ?? 'Company Profile' }}
                                    </h2>

                                    @if (!empty($profile->subtitle))
                                        <p class="text-xl text-slate-600 font-medium">{{ $profile->subtitle }}</p>
                                    @endif
                                </div>

                                @if (!empty($profile->description))
                                    <div class="prose prose-lg text-slate-700 max-w-none">
                                        <p class="leading-relaxed">{{ $profile->description }}</p>
                                    </div>
                                @endif

                                <!-- Services Section -->
                                <div class="space-y-4">
                                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                                        <div class="w-1 h-6 bg-gradient-to-b from-indigo-500 to-purple-600 rounded-full">
                                        </div>
                                        Layanan Utama
                                    </h3>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        @php
                                            $services = array_filter(
                                                array_map('trim', explode("\n", $profile->main_services ?? '')),
                                            );
                                        @endphp

                                        @forelse($services as $service)
                                            <div
                                                class="flex items-start gap-3 p-3 rounded-lg bg-slate-50 hover:bg-slate-100 transition-colors">
                                                <div
                                                    class="flex-shrink-0 w-6 h-6 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-full flex items-center justify-center mt-0.5">
                                                    <svg class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="3" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>
                                                <span class="text-slate-700 font-medium">{{ $service }}</span>
                                            </div>
                                        @empty
                                            <div
                                                class="col-span-full p-4 text-center text-slate-500 bg-slate-50 rounded-lg">
                                                Belum ada layanan utama yang ditambahkan.
                                            </div>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- CTA Section -->
                                <div class="pt-6">
                                    <div class="flex flex-col sm:flex-row gap-4">
                                        <a href="#contact"
                                            class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                            </svg>
                                            Hubungi Kami
                                        </a>

                                        <a href="#services"
                                            class="inline-flex items-center justify-center gap-2 bg-white text-slate-700 font-semibold px-6 py-3 rounded-xl border-2 border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition-all">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Pelajari Selengkapnya
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Image Section -->
                        <div class="relative lg:h-auto h-80">
                            <div class="absolute inset-0 bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100"></div>

                            @php
                                $imageExists = false;
                                if (!empty($profile->image)) {
                                    $imagePath = $profile->image;
                                    $fullPath = storage_path('app/public/' . $imagePath);

                                    // Check for the file with original extension
                                    $imageExists = file_exists($fullPath);

                                    // If not found, try different extensions
                                    if (!$imageExists) {
                                        $pathInfo = pathinfo($fullPath);
                                        $basePath = $pathInfo['dirname'] . '/' . $pathInfo['filename'];
                                        foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
                                            if (file_exists($basePath . '.' . $ext)) {
                                                $imagePath =
                                                    pathinfo($profile->image, PATHINFO_DIRNAME) .
                                                    '/' .
                                                    pathinfo($profile->image, PATHINFO_FILENAME) .
                                                    '.' .
                                                    $ext;
                                                $imageExists = true;
                                                break;
                                            }
                                        }
                                    }
                                }
                            @endphp

                            @if ($imageExists)
                                <div class="absolute inset-0 p-6 lg:p-8">
                                    <img src="{{ asset('storage/' . $imagePath) }}"
                                        alt="{{ $profile->title ?? 'Company image' }}"
                                        class="w-full h-full object-cover rounded-2xl shadow-2xl" loading="lazy">
                                </div>
                            @else
                                <div class="absolute inset-0 flex items-center justify-center p-8">
                                    <div class="text-center space-y-4">
                                        <div
                                            class="mx-auto w-32 h-32 bg-white/60 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-lg">
                                            <svg class="w-16 h-16 text-slate-400" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <p class="text-slate-500 font-medium">Tidak ada gambar perusahaan</p>
                                        <p class="text-sm text-slate-400">Upload gambar melalui admin panel</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Additional Company Information -->
    <section class="py-16 bg-slate-50">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center">
                <h3 class="text-2xl font-bold text-slate-900 mb-4">Mengapa Memilih Mahestra Printing?</h3>
                <p class="text-slate-600 leading-relaxed">
                    Dengan pengalaman bertahun-tahun dalam industri percetakan, kami menghadirkan solusi terbaik
                    untuk kebutuhan promosi dan branding bisnis Anda. Teknologi modern dan tim profesional kami
                    memastikan setiap produk yang dihasilkan memiliki kualitas tinggi dan sesuai dengan ekspektasi Anda.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-slate-900 mb-2">Cetak Cepat</h4>
                        <p class="text-sm text-slate-600">Proses produksi yang efisien untuk hasil cepat tanpa mengorbankan
                            kualitas</p>
                    </div>

                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-slate-900 mb-2">Kualitas Terjamin</h4>
                        <p class="text-sm text-slate-600">Material premium dan teknologi modern untuk hasil berkualitas
                            tinggi</p>
                    </div>

                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-slate-900 mb-2">Harga Kompetitif</h4>
                        <p class="text-sm text-slate-600">Harga yang bersaing dengan layanan konsultasi gratis</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
