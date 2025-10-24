<!-- Preview Services Section -->
<section id="layanan" class="py-16 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                Layanan & Informasi
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Akses berbagai layanan dan informasi terkini dari Dinas PMD Kabupaten Katingan
            </p>
        </div>

        <!-- Service Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- Berita Card -->
            <div class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border-t-4 border-blue-500 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg mb-4 group-hover:bg-blue-200 transition-colors duration-300">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Berita Terkini</h3>
                    <p class="text-gray-600 text-sm mb-4 leading-relaxed">
                        Informasi terbaru seputar kegiatan dan program kerja dinas
                    </p>
                    <a href="{{ route('news') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium text-sm group-hover:translate-x-1 transition-transform duration-300">
                        Lihat Semua
                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Agenda Card -->
            <div class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border-t-4 border-green-500 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg mb-4 group-hover:bg-green-200 transition-colors duration-300">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Agenda Kegiatan</h3>
                    <p class="text-gray-600 text-sm mb-4 leading-relaxed">
                        Jadwal kegiatan dan event mendatang yang dapat diikuti masyarakat
                    </p>
                    <a href="{{ route('agenda') }}" class="inline-flex items-center text-green-600 hover:text-green-700 font-medium text-sm group-hover:translate-x-1 transition-transform duration-300">
                        Lihat Agenda
                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>                </div>
            </div>

            <!-- Dokumen Card -->
            <div class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border-t-4 border-purple-500 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-center w-12 h-12 bg-purple-100 rounded-lg mb-4 group-hover:bg-purple-200 transition-colors duration-300">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Dokumen Publik</h3>
                    <p class="text-gray-600 text-sm mb-4 leading-relaxed">
                        Unduh dokumen resmi, peraturan, dan informasi publik lainnya
                    </p>
                    <a href="{{ route('documents') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 font-medium text-sm group-hover:translate-x-1 transition-transform duration-300">
                        Unduh Dokumen
                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Galeri Card -->
            <div class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border-t-4 border-orange-500 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-center w-12 h-12 bg-orange-100 rounded-lg mb-4 group-hover:bg-orange-200 transition-colors duration-300">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Galeri Foto</h3>
                    <p class="text-gray-600 text-sm mb-4 leading-relaxed">
                        Dokumentasi kegiatan dan program kerja dalam bentuk foto
                    </p>
                    <a href="{{ route('gallery') }}" class="inline-flex items-center text-orange-600 hover:text-orange-700 font-medium text-sm group-hover:translate-x-1 transition-transform duration-300">
                        Lihat Galeri
                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Simple Stats -->
        <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="text-3xl font-bold text-blue-600 mb-2">150+</div>
                <p class="text-gray-600 font-medium">Desa Binaan</p>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-green-600 mb-2">50+</div>
                <p class="text-gray-600 font-medium">Program Aktif</p>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-purple-600 mb-2">25K+</div>
                <p class="text-gray-600 font-medium">Masyarakat Terdampak</p>
            </div>
        </div>
    </div>
</section>
