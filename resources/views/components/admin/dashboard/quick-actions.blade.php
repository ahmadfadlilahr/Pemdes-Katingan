<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Card Header -->
    <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-white">
        <div class="flex items-center space-x-3">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Aksi Cepat</h3>
        </div>
    </div>

    <!-- Card Body -->
    <div class="p-6">
        <div class="space-y-3">
            <!-- Create News -->
            <a href="{{ route('admin.news.create') }}"
               class="group flex items-center p-4 border border-gray-200 rounded-xl hover:border-blue-200 hover:bg-blue-50 transition-all duration-200">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 group-hover:bg-blue-200 rounded-xl flex items-center justify-center transition-colors duration-200">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <h4 class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                        Buat Berita Baru
                    </h4>
                    <p class="text-xs text-gray-500 mt-0.5">Tulis dan publikasikan berita terbaru</p>
                </div>
                <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            <!-- Manage News -->
            <a href="{{ route('admin.news.index') }}"
               class="group flex items-center p-4 border border-gray-200 rounded-xl hover:border-green-200 hover:bg-green-50 transition-all duration-200">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 group-hover:bg-green-200 rounded-xl flex items-center justify-center transition-colors duration-200">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <h4 class="text-sm font-semibold text-gray-900 group-hover:text-green-600 transition-colors duration-200">
                        Kelola Semua Berita
                    </h4>
                    <p class="text-xs text-gray-500 mt-0.5">Edit, hapus, atau kelola status berita</p>
                </div>
                <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            <!-- Create Agenda -->
            <a href="{{ route('admin.agenda.create') }}"
               class="group flex items-center p-4 border border-gray-200 rounded-xl hover:border-red-200 hover:bg-red-50 transition-all duration-200">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-red-100 group-hover:bg-red-200 rounded-xl flex items-center justify-center transition-colors duration-200">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <h4 class="text-sm font-semibold text-gray-900 group-hover:text-red-600 transition-colors duration-200">
                        Buat Agenda Baru
                    </h4>
                    <p class="text-xs text-gray-500 mt-0.5">Buat dan jadwalkan agenda kegiatan</p>
                </div>
                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            <!-- Manage Agenda -->
            <a href="{{ route('admin.agenda.index') }}"
               class="group flex items-center p-4 border border-gray-200 rounded-xl hover:border-orange-200 hover:bg-orange-50 transition-all duration-200">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-orange-100 group-hover:bg-orange-200 rounded-xl flex items-center justify-center transition-colors duration-200">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <h4 class="text-sm font-semibold text-gray-900 group-hover:text-orange-600 transition-colors duration-200">
                        Kelola Agenda
                    </h4>
                    <p class="text-xs text-gray-500 mt-0.5">Edit, update status dan kelola agenda</p>
                </div>
                <svg class="w-5 h-5 text-gray-400 group-hover:text-orange-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</div>
