<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-white to-blue-50 overflow-hidden">
        <div class="h-screen flex overflow-hidden">
            <!-- Left Side - Branding Section -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-600 to-blue-800 p-12 flex-col justify-between relative overflow-hidden">
                <!-- Decorative Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                    <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full translate-x-1/2 translate-y-1/2"></div>
                </div>

                <!-- Logo & Title -->
                <div class="relative z-10">
                    <div class="flex items-center space-x-4 mb-8">
                        <img src="{{ asset('Logo_Dinas_PMD.png') }}" alt="Logo Dinas PMD" class="h-20 w-20 object-contain bg-white rounded-xl p-2 shadow-lg">
                        <div>
                            <h1 class="text-3xl font-bold text-white">Dinas PMD</h1>
                            <p class="text-blue-100 text-sm">Kabupaten Katingan</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <h2 class="text-4xl font-bold text-white leading-tight">
                            Sistem Informasi<br>Manajemen Website
                        </h2>
                        <p class="text-blue-100 text-lg">
                            Portal administrasi untuk mengelola konten dan informasi website Dinas Pemberdayaan Masyarakat dan Desa
                        </p>
                    </div>
                </div>

                <!-- Features -->
                <div class="relative z-10 space-y-4">
                    <div class="flex items-start space-x-3 text-white">
                        <svg class="w-6 h-6 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold">Kelola Konten Website</h3>
                            <p class="text-sm text-blue-100">Berita, Agenda, Galeri, dan Dokumen</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3 text-white">
                        <svg class="w-6 h-6 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold">Manajemen Informasi</h3>
                            <p class="text-sm text-blue-100">Struktur Organisasi, Visi Misi, Kata Sambutan</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3 text-white">
                        <svg class="w-6 h-6 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold">Keamanan Terjamin</h3>
                            <p class="text-sm text-blue-100">Sistem login aman dengan role-based access</p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="relative z-10 text-blue-100 text-sm">
                    <p>&copy; {{ date('Y') }} Dinas PMD Kabupaten Katingan. All rights reserved.</p>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 overflow-y-auto">
                <div class="w-full max-w-md my-auto">
                    <!-- Mobile Logo -->
                    <div class="lg:hidden mb-8 text-center">
                        <img src="{{ asset('Logo_Dinas_PMD.png') }}" alt="Logo Dinas PMD" class="h-20 w-20 object-contain mx-auto mb-4">
                        <h1 class="text-2xl font-bold text-gray-900">Dinas PMD</h1>
                        <p class="text-gray-600 text-sm">Kabupaten Katingan</p>
                    </div>

                    <!-- Login Card -->
                    <div class="bg-white rounded-2xl shadow-xl p-8 sm:p-10">
                        <div class="mb-8">
                            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Selamat Datang</h2>
                            <p class="text-gray-600">Masuk ke panel administrasi</p>
                        </div>

                        {{ $slot }}
                    </div>

                    <!-- Help Text -->
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            Mengalami kendala? Hubungi
                            <a href="mailto:info@pmdkatingan.go.id" class="text-blue-600 hover:text-blue-700 font-medium">
                                Administrator
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
