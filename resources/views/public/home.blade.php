<x-public-layout title="Beranda - Dinas PMD Kabupaten Katingan" description="Website resmi Dinas Pemberdayaan Masyarakat dan Desa Kabupaten Katingan. Melayani masyarakat dengan berbagai program pemberdayaan dan pengembangan desa.">


    @include('components.public.hero')


    @include('components.public.stats-section')


    <x-public.welcome-message :welcomeMessage="$welcomeMessage" />


    @include('components.public.main-content-grid')

    
    @include('components.public.latest-gallery')

</x-public-layout>
