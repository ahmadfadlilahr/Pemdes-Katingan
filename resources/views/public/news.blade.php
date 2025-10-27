<x-public-layout title="Berita - Dinas PMD Kabupaten Katingan" description="Berita terkini dan informasi terbaru dari Dinas Pemberdayaan Masyarakat dan Desa Kabupaten Katingan">

    <!-- Page Header -->
    @include('components.public.page-header', [
        'title' => 'Berita Terkini',
        'subtitle' => 'Ikuti perkembangan dan informasi terbaru dari Dinas PMD Kabupaten Katingan',
        'breadcrumbs' => [
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Berita', 'url' => null]
        ]
    ])

    <!-- Main Content -->
    <section class="py-12 sm:py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10">

                <!-- Main Content Area -->
                <div class="lg:col-span-2">

                    @if($news && $news->count() > 0)
                        <!-- News Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                            @foreach($news as $item)
                                @include('components.public.news-card', ['news' => $item])
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $news->links() }}
                        </div>
                    @else
                        <!-- Empty State -->
                        @include('components.public.empty-state', [
                            'icon' => 'document',
                            'title' => 'Belum Ada Berita',
                            'message' => 'Berita dan informasi terbaru akan segera hadir di sini.'
                        ])
                    @endif

                </div>

                <!-- Sidebar -->
                <aside class="lg:col-span-1">
                    <div class="sticky top-4 space-y-6">

                        <!-- Search Box -->
                        @include('components.public.news-search')

                        <!-- Latest News Sidebar -->
                        @include('components.public.news-sidebar', ['latestNews' => $latestNews])

                        <!-- Categories (Optional - if you have categories) -->

                    </div>
                </aside>

            </div>

        </div>
    </section>

</x-public-layout>
