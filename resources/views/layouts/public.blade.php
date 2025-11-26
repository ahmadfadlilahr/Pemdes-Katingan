<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ $title ?? 'Dinas PMD Kabupaten Katingan - Pemberdayaan Masyarakat dan Desa' }}</title>
    <meta name="description" content="{{ $description ?? 'Website resmi Dinas Pemberdayaan Masyarakat dan Desa Kabupaten Katingan. Informasi program pemberdayaan masyarakat, berita desa, agenda kegiatan, dan layanan publik Kalimantan Tengah.' }}">
    <meta name="keywords" content="Dinas PMD Katingan, Pemberdayaan Masyarakat Desa, Kabupaten Katingan, Kalimantan Tengah, Pemerintah Daerah, Program Desa, Berita Desa, Layanan Publik">
    <meta name="author" content="Dinas Pemberdayaan Masyarakat dan Desa Kabupaten Katingan">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">


    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title ?? 'Dinas PMD Kabupaten Katingan' }}">
    <meta property="og:description" content="{{ $description ?? 'Website resmi Dinas Pemberdayaan Masyarakat dan Desa Kabupaten Katingan' }}">
    <meta property="og:image" content="{{ asset('logo-dinas.png') }}">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="Dinas PMD Kabupaten Katingan">


    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ $title ?? 'Dinas PMD Kabupaten Katingan' }}">
    <meta name="twitter:description" content="{{ $description ?? 'Website resmi Dinas Pemberdayaan Masyarakat dan Desa Kabupaten Katingan' }}">
    <meta name="twitter:image" content="{{ asset('logo-dinas.png') }}">


    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />


    <link rel="icon" href="{{ asset('logo-dinas.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('logo-dinas.png') }}">

    <!-- Alpine.js for interactive components -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-gray-900">
    <div class="min-h-screen">

        @include('components.public.navbar')


        <main>
            {{ $slot }}
        </main>


        @include('components.public.footer')


        <x-public.back-to-top />
    </div>
</body>
</html>
