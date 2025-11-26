<section class="py-16 lg:py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                Berita & Agenda Terbaru
            </h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Ikuti perkembangan terkini dan jadwal kegiatan dari Dinas PMD Kabupaten Katingan
            </p>
        </div>


        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">

            <div class="lg:col-span-2 space-y-6 lg:space-y-8">

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6 lg:p-8">
                    @include('components.public.latest-news')
                </div>


                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6 lg:p-8">
                    @include('components.public.upcoming-events')
                </div>
            </div>


            <div class="lg:col-span-1">
                <div class="space-y-6 sticky top-4">

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
                        @include('components.public.quick-info', ['contact' => $contact ?? null])
                    </div>


                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-base sm:text-lg font-semibold text-gray-900">Dokumen Publik</h4>
                            <a href="{{ route('documents') }}" class="text-xs sm:text-sm text-blue-600 hover:text-blue-700 font-medium group flex items-center">
                                Lihat Semua
                                <svg class="ml-1 w-3 h-3 sm:w-4 sm:h-4 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>

                        @if($latestDocuments && $latestDocuments->count() > 0)
                        <div class="space-y-2 sm:space-y-3">
                            @foreach($latestDocuments as $document)
                            <a href="{{ route('documents') }}"
                               class="flex items-center p-2 sm:p-3 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all duration-200 group">
                                <div class="flex-shrink-0">
                                    @php
                                        $fileExtension = strtolower(pathinfo($document->file_path, PATHINFO_EXTENSION));
                                        $bgColor = 'bg-blue-100';
                                        $iconColor = 'text-blue-600';

                                        if($fileExtension === 'pdf') {
                                            $bgColor = 'bg-red-100';
                                            $iconColor = 'text-red-600';
                                        } elseif(in_array($fileExtension, ['doc', 'docx'])) {
                                            $bgColor = 'bg-blue-100';
                                            $iconColor = 'text-blue-600';
                                        } elseif(in_array($fileExtension, ['xls', 'xlsx'])) {
                                            $bgColor = 'bg-green-100';
                                            $iconColor = 'text-green-600';
                                        } elseif(in_array($fileExtension, ['ppt', 'pptx'])) {
                                            $bgColor = 'bg-orange-100';
                                            $iconColor = 'text-orange-600';
                                        }
                                    @endphp
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 {{ $bgColor }} rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-2 sm:ml-3 flex-1 min-w-0">
                                    <p class="text-xs sm:text-sm font-medium text-gray-900 group-hover:text-blue-700 truncate">
                                        {{ $document->title }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ strtoupper($fileExtension) }} • {{ $document->created_at->format('d M Y') }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0 ml-2">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3"></path>
                                    </svg>
                                </div>
                            </a>
                            @endforeach
                        </div>
                        @else
                        
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">Belum ada dokumen</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
