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
                <!-- Organization Chart Hierarchy -->
                <div class="space-y-8 lg:space-y-12">
                    @foreach($groupedStructures as $order => $levelStructures)
                        <!-- Hierarchy Level Row -->
                        <div class="hierarchy-level" data-level="{{ $order }}" data-aos="fade-up" data-aos-delay="{{ ($order - 1) * 100 }}">

                            <!-- Grid Layout for Same Level Members - Portrait Card Optimized with Smart Centering -->
                            @php
                                $count = $levelStructures->count();
                                // Define grid classes based on count for optimal centering
                                if ($count === 1) {
                                    $gridClass = 'grid grid-cols-1 place-items-center';
                                } elseif ($count === 2) {
                                    $gridClass = 'flex flex-wrap justify-center'; // Flexbox untuk 2 card centered
                                } elseif ($count === 3) {
                                    $gridClass = 'flex flex-wrap justify-center'; // Flexbox untuk 3 card centered
                                } else {
                                    $gridClass = 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 place-items-center';
                                }
                            @endphp

                            <div class="{{ $gridClass }} gap-6 lg:gap-8 max-w-7xl mx-auto">
                                @foreach($levelStructures as $index => $structure)
                                    @include('components.public.organization-card-hierarchical', [
                                        'structure' => $structure,
                                        'index' => $index,
                                        'totalInLevel' => $levelStructures->count(),
                                        'level' => $order
                                    ])
                                @endforeach
                            </div>

                            <!-- Connecting Line (except for last level) -->
                            @if(!$loop->last)
                                <div class="flex justify-center mt-8 mb-4">
                                    <div class="relative">
                                        <!-- Vertical Line -->
                                        <div class="w-0.5 h-12 bg-gradient-to-b from-blue-400 to-blue-300 mx-auto"></div>
                                        <!-- Arrow Down -->
                                        <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2">
                                            <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v10.586l3.293-3.293a1 1 0 111.414 1.414l-5 5a1 1 0 01-1.414 0l-5-5a1 1 0 111.414-1.414L9 14.586V4a1 1 0 011-1z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
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
