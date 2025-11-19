<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>{{ $title ?? 'Dinas PMD Kabupaten Katingan - Pemberdayaan Masyarakat dan Desa' }}</title>
    <meta name="description" content="{{ $description ?? 'Website resmi Dinas Pemberdayaan Masyarakat dan Desa Kabupaten Katingan. Informasi program pemberdayaan masyarakat, berita desa, agenda kegiatan, dan layanan publik Kalimantan Tengah.' }}">
    <meta name="keywords" content="Dinas PMD Katingan, Pemberdayaan Masyarakat Desa, Kabupaten Katingan, Kalimantan Tengah, Pemerintah Daerah, Program Desa, Berita Desa, Layanan Publik">
    <meta name="author" content="Dinas Pemberdayaan Masyarakat dan Desa Kabupaten Katingan">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title ?? 'Dinas PMD Kabupaten Katingan' }}">
    <meta property="og:description" content="{{ $description ?? 'Website resmi Dinas Pemberdayaan Masyarakat dan Desa Kabupaten Katingan' }}">
    <meta property="og:image" content="{{ asset('Logo_Dinas_PMD.png') }}">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="Dinas PMD Kabupaten Katingan">

    <!-- X (formerly Twitter) -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ $title ?? 'Dinas PMD Kabupaten Katingan' }}">
    <meta name="twitter:description" content="{{ $description ?? 'Website resmi Dinas Pemberdayaan Masyarakat dan Desa Kabupaten Katingan' }}">
    <meta name="twitter:image" content="{{ asset('Logo_Dinas_PMD.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('Logo_Dinas_PMD.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('Logo_Dinas_PMD.png') }}">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-gray-900">
    <div class="min-h-screen">
        <!-- Navigation -->
        @include('components.public.navbar')

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        <!-- Footer -->
        @include('components.public.footer')
    </div>
</body>
</html>
