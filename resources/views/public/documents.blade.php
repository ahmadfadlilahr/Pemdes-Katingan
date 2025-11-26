<x-public-layout title="Dokumen Publik - Dinas PMD Kabupaten Katingan" description="Akses berbagai dokumen publik, regulasi, dan informasi resmi dari Dinas Pemberdayaan Masyarakat dan Desa Kabupaten Katingan">


    @include('components.public.page-header', [
        'title' => 'Dokumen Publik',
        'subtitle' => 'Akses dan unduh berbagai dokumen, regulasi, dan informasi resmi',
        'breadcrumbs' => [
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Dokumen', 'url' => null]
        ]
    ])


    <section class="py-12 sm:py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10">


                <div class="lg:col-span-2">


                    @include('components.public.document-search', ['categories' => $categories])


                    @if($documents->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                            @foreach($documents as $document)
                                @include('components.public.document-card', ['document' => $document])
                            @endforeach
                        </div>


                        <div class="mt-8">
                            {{ $documents->links() }}
                        </div>
                    @else

                        @include('components.public.empty-state', [
                            'icon' => 'document',
                            'title' => 'Dokumen Tidak Ditemukan',
                            'message' => request('search') || request('category')
                                ? 'Tidak ada dokumen yang sesuai dengan pencarian Anda. Coba kata kunci lain atau hapus filter.'
                                : 'Belum ada dokumen yang tersedia saat ini. Silakan cek kembali nanti.'
                        ])
                    @endif

                </div>


                <aside class="lg:col-span-1">
                    <div class="sticky top-4 space-y-6">


                        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl shadow-lg p-6 text-white">
                            <div class="flex items-center mb-4">
                                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <div>
                                    <h3 class="text-3xl font-bold">{{ \App\Models\Document::where('is_active', true)->count() }}</h3>
                                    <p class="text-blue-100 text-sm">Total Dokumen</p>
                                </div>
                            </div>
                            <p class="text-blue-50 text-sm">
                                Berbagai dokumen resmi tersedia untuk diunduh
                            </p>
                        </div>


                        @include('components.public.document-sidebar', ['popularDocuments' => $popularDocuments])


                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <h4 class="font-semibold text-blue-900 mb-2">Informasi</h4>
                                    <p class="text-sm text-blue-800 leading-relaxed">
                                        Semua dokumen disediakan dalam format digital untuk kemudahan akses. Jika mengalami kesulitan, silakan hubungi kami.
                                    </p>
                                </div>
                            </div>
                        </div>

                        
                        @if($categories && $categories->count() > 0)
                        <div class="bg-white rounded-xl shadow-md p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Kategori Tersedia
                            </h3>
                            <div class="space-y-2">
                                @foreach($categories as $cat)
                                    <a href="{{ route('documents', ['category' => $cat]) }}"
                                       class="block px-3 py-2 rounded-lg text-sm {{ request('category') === $cat ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }} transition-colors duration-200">
                                        <span class="flex items-center justify-between">
                                            <span>{{ $cat }}</span>
                                            <span class="text-xs {{ request('category') === $cat ? 'text-blue-600' : 'text-gray-400' }}">
                                                {{ \App\Models\Document::where('is_active', true)->where('category', $cat)->count() }}
                                            </span>
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        @endif

                    </div>
                </aside>

            </div>

        </div>
    </section>

</x-public-layout>
