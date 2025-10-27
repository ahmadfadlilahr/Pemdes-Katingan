@props(['latestGalleries', 'totalGalleries'])

<!-- Stats Card -->
<div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl shadow-lg p-6 text-white">
    <div class="flex items-center mb-4">
        <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        <div>
            <h3 class="text-3xl font-bold">{{ $totalGalleries }}</h3>
            <p class="text-blue-100 text-sm">Total Galeri</p>
        </div>
    </div>
    <p class="text-blue-50 text-sm">
        Dokumentasi kegiatan dan momen penting
    </p>
</div>

<!-- Latest Gallery -->
<div class="bg-white rounded-xl shadow-md p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center">
        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        Galeri Terbaru
    </h3>

    @if($latestGalleries && $latestGalleries->count() > 0)
        <div class="space-y-4">
            @foreach($latestGalleries as $gallery)
                <article class="group">
                    <div class="flex gap-3 hover:bg-gray-50 p-3 rounded-lg transition-colors duration-200">
                        <!-- Thumbnail -->
                        <div class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden bg-gray-100 group-hover:scale-105 transition-transform duration-300">
                            @if($gallery->image)
                                <img src="{{ Storage::url($gallery->image) }}"
                                     alt="{{ $gallery->title }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-semibold text-gray-900 line-clamp-2 group-hover:text-blue-600 transition-colors duration-200 mb-2">
                                {{ $gallery->title }}
                            </h4>
                            <p class="text-xs text-gray-500 flex items-center">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $gallery->created_at->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                </article>

                @if(!$loop->last)
                    <hr class="border-gray-200">
                @endif
            @endforeach
        </div>
    @else
        <p class="text-gray-500 text-sm text-center py-4">Belum ada galeri</p>
    @endif
</div>

<!-- Info Card -->
<div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
    <div class="flex items-start">
        <svg class="w-6 h-6 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div>
            <h4 class="font-semibold text-blue-900 mb-2">Informasi</h4>
            <p class="text-sm text-blue-800 leading-relaxed">
                Klik pada gambar untuk melihat dalam ukuran penuh.
            </p>
        </div>
    </div>
</div>
