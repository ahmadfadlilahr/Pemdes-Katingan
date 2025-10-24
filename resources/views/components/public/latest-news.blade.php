<!-- Latest News Section -->
<section class="bg-white">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <h3 class="text-2xl font-bold text-gray-900">Berita Terbaru</h3>
            <a href="{{ route('news') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center">
                Lihat Semua
                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
        <div class="w-20 h-1 bg-blue-600 mt-2"></div>
    </div>

    <div class="space-y-6">
        <!-- Featured News -->
        <article class="group cursor-pointer">
            <div class="bg-gray-200 rounded-lg h-48 mb-4 overflow-hidden">
                <div class="w-full h-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                    <svg class="w-16 h-16 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <div class="space-y-2">
                <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">Program Desa</span>
                <h4 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200 line-clamp-2">
                    Peluncuran Program Pemberdayaan Masyarakat Desa Mandiri 2024
                </h4>
                <p class="text-gray-600 text-sm line-clamp-3">
                    Dinas PMD Kabupaten Katingan meluncurkan program pemberdayaan masyarakat desa mandiri yang akan menjangkau 50 desa di seluruh kabupaten dengan fokus pada peningkatan ekonomi masyarakat.
                </p>
                <div class="flex items-center text-xs text-gray-500 mt-3">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    15 Oktober 2025
                </div>
            </div>
        </article>

        <!-- News List -->
        <div class="space-y-4 border-t border-gray-100 pt-6">
            <article class="flex space-x-4 group hover:bg-gray-50 p-3 rounded-lg transition-colors duration-200 cursor-pointer">
                <div class="w-20 h-16 bg-gray-200 rounded-lg flex-shrink-0 overflow-hidden">
                    <div class="w-full h-full bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <h5 class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200 line-clamp-2">
                        Sosialisasi Dana Desa 2024 di Kecamatan Kasongan
                    </h5>
                    <p class="text-xs text-gray-600 mt-1 line-clamp-2">
                        Kegiatan sosialisasi penggunaan dana desa yang efektif dan transparan...
                    </p>
                    <span class="text-xs text-gray-500 mt-2 block">12 Oktober 2025</span>
                </div>
            </article>

            <article class="flex space-x-4 group hover:bg-gray-50 p-3 rounded-lg transition-colors duration-200 cursor-pointer">
                <div class="w-20 h-16 bg-gray-200 rounded-lg flex-shrink-0 overflow-hidden">
                    <div class="w-full h-full bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <h5 class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200 line-clamp-2">
                        Pelatihan BUMDES untuk Peningkatan Ekonomi Desa
                    </h5>
                    <p class="text-xs text-gray-600 mt-1 line-clamp-2">
                        Program pelatihan manajemen BUMDES untuk meningkatkan perekonomian desa...
                    </p>
                    <span class="text-xs text-gray-500 mt-2 block">10 Oktober 2025</span>
                </div>
            </article>

            <article class="flex space-x-4 group hover:bg-gray-50 p-3 rounded-lg transition-colors duration-200 cursor-pointer">
                <div class="w-20 h-16 bg-gray-200 rounded-lg flex-shrink-0 overflow-hidden">
                    <div class="w-full h-full bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <h5 class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200 line-clamp-2">
                        Monitoring dan Evaluasi Program Desa Tahun 2024
                    </h5>
                    <p class="text-xs text-gray-600 mt-1 line-clamp-2">
                        Kegiatan monitoring dan evaluasi pelaksanaan program pemberdayaan desa...
                    </p>
                    <span class="text-xs text-gray-500 mt-2 block">8 Oktober 2025</span>
                </div>
            </article>
        </div>
    </div>
</section>
