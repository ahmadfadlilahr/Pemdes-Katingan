<x-public-layout title="Beranda - Dinas PMD Kabupaten Katingan" description="Website resmi Dinas Pemberdayaan Masyarakat dan Desa Kabupaten Katingan. Melayani masyarakat dengan berbagai program pemberdayaan dan pengembangan desa.">

    <!-- Hero Section -->
    @include('components.public.hero')

    <!-- Quick Stats Section -->
    @include('components.public.stats-section')

    <!-- Welcome Message Section -->
    <x-public.welcome-message :welcomeMessage="$welcomeMessage" />

    <!-- Main Content Grid Layout -->
    @include('components.public.main-content-grid')

    <!-- Latest Gallery Section -->
    @include('components.public.latest-gallery')

</x-public-layout>
