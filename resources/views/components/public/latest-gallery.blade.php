<!-- Latest Gallery Section -->
<section class="py-12 sm:py-16 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-8 sm:mb-12">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-3 sm:mb-4">
                Galeri Kegiatan
            </h2>
            <p class="text-base sm:text-lg text-gray-600 max-w-3xl mx-auto">
                Dokumentasi kegiatan dan program-program Dinas PMD Kabupaten Katingan
            </p>
        </div>

        @if($latestGallery && $latestGallery->count() > 0)
        <!-- Gallery Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4 mb-8">
            @foreach($latestGallery as $index => $photo)
            <div class="group relative overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-all duration-300 {{ $index >= 4 ? 'hidden sm:block' : '' }} {{ $index >= 3 ? 'hidden lg:block' : '' }}">
                <div class="aspect-square">
                    @if($photo->image)
                    <img src="{{ Storage::url($photo->image) }}"
                         alt="{{ $photo->title }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    @endif
                </div>

                <!-- Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="absolute bottom-0 left-0 right-0 p-3 sm:p-4">
                        <h4 class="text-white text-xs sm:text-sm font-semibold line-clamp-2">
                            {{ $photo->title }}
                        </h4>
                        @if($photo->description)
                        <p class="text-white/80 text-xs mt-1 line-clamp-1">
                            {{ Str::limit(strip_tags($photo->description), 50) }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- View All Button -->
        <div class="text-center">
            <a href="{{ route('gallery') }}"
               class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 border-2 border-blue-600 text-blue-600 font-semibold rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-200 group">
                Lihat Semua Galeri
                <svg class="ml-2 w-5 h-5 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
        @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <svg class="mx-auto h-20 w-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada galeri</h3>
            <p class="mt-2 text-sm text-gray-500">Foto-foto kegiatan akan ditampilkan di sini.</p>
        </div>
        @endif
    </div>
</section>
