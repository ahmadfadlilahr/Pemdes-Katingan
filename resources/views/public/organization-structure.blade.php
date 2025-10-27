<x-public-layout title="Struktur Organisasi - Dinas PMD Kabupaten Katingan" description="Struktur Organisasi Dinas Pemberdayaan Masyarakat dan Desa Kabupaten Katingan">

    <!-- Hero Section -->
    @include('components.public.page-header', [
        'title' => 'Struktur Organisasi',
        'subtitle' => 'Dinas Pemberdayaan Masyarakat dan Desa Kabupaten Katingan',
        'breadcrumbs' => [
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Struktur Organisasi', 'url' => null]
        ]
    ])

    <!-- Main Content -->
    <section class="py-12 sm:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($structures && $structures->count() > 0)
                <!-- Organization Chart Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    @foreach($structures as $index => $structure)
                        @include('components.public.organization-card', [
                            'structure' => $structure,
                            'index' => $index
                        ])
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                @include('components.public.empty-state', [
                    'icon' => 'organization',
                    'title' => 'Struktur Organisasi Belum Tersedia',
                    'message' => 'Informasi struktur organisasi sedang dalam proses penyusunan.'
                ])
            @endif

        </div>
    </section>

</x-public-layout>
