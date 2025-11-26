<x-public-layout :title="$document->title . ' - Dokumen Publik'" :description="Str::limit(strip_tags($document->description), 160)">


    @include('components.public.page-header', [
        'title' => 'Detail Dokumen',
        'subtitle' => null,
        'breadcrumbs' => [
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Dokumen', 'url' => route('documents')],
            ['label' => Str::limit($document->title, 30), 'url' => null]
        ]
    ])

    @php

        $iconClass = match(strtolower($document->file_type ?? 'pdf')) {
            'pdf' => 'text-red-600',
            'doc', 'docx' => 'text-blue-600',
            'xls', 'xlsx' => 'text-green-600',
            'ppt', 'pptx' => 'text-orange-600',
            'zip', 'rar' => 'text-purple-600',
            default => 'text-gray-600',
        };

        $bgClass = match(strtolower($document->file_type ?? 'pdf')) {
            'pdf' => 'from-red-600 to-red-700',
            'doc', 'docx' => 'from-blue-600 to-blue-700',
            'xls', 'xlsx' => 'from-green-600 to-green-700',
            'ppt', 'pptx' => 'from-orange-600 to-orange-700',
            'zip', 'rar' => 'from-purple-600 to-purple-700',
            default => 'from-gray-600 to-gray-700',
        };


        $canPreview = in_array(strtolower($document->file_type), ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp']);
    @endphp


    <section class="py-12 sm:py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10">


                <article class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">


                        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 text-white p-6 sm:p-8">


                            <div class="flex items-center justify-between mb-4">
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-white/20 backdrop-blur-sm uppercase text-white">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ strtoupper($document->file_type) }} FILE
                                </span>

                                @if($document->category)
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-semibold bg-white/20 backdrop-blur-sm text-white">
                                    {{ $document->category }}
                                </span>
                                @endif
                            </div>


                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-4 text-white">
                                {{ $document->title }}
                            </h1>


                            <div class="flex flex-wrap gap-4 text-sm text-white/90">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                                    </svg>
                                    {{ $document->file_size_formatted }}
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    {{ $document->download_count ?? 0 }} unduhan
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $document->created_at->format('d M Y') }}
                                </div>
                            </div>

                        </div>


                        <div class="p-6 sm:p-8 lg:p-10">


                            @if($document->description)
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Deskripsi Dokumen</h3>
                                <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                                    {!! nl2br(e($document->description)) !!}
                                </div>
                            </div>
                            @endif

                            {{-- <!-- Action Buttons -->
                            <div class="bg-gray-50 rounded-xl p-6 mb-8">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Dokumen</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                                    <!-- Preview Button (if applicable) -->
                                    @if($canPreview)
                                    <a href="{{ route('documents.preview', $document->id) }}"
                                       target="_blank"
                                       class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-indigo-800 transition-all duration-200 shadow-md hover:shadow-lg group">
                                        <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Lihat Dokumen
                                    </a>
                                    @endif

                                    <!-- Download Button -->
                                    <a href="{{ route('documents.download', $document->id) }}"
                                       class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-700 text-white rounded-lg font-semibold hover:from-green-700 hover:to-emerald-800 transition-all duration-200 shadow-md hover:shadow-lg group">
                                        <svg class="w-5 h-5 mr-2 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        Unduh Dokumen
                                    </a>

                                </div>
                            </div> --}}


                            <div class="border-t border-gray-200 pt-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi File</h3>
                                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Nama File</dt>
                                        <dd class="mt-1 text-sm text-gray-900 font-mono truncate">{{ $document->file_name }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Tipe File</dt>
                                        <dd class="mt-1 text-sm text-gray-900 uppercase">{{ $document->file_type }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Ukuran File</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $document->file_size_formatted }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Total Unduhan</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $document->download_count ?? 0 }} kali</dd>
                                    </div>
                                    @if($document->category)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Kategori</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $document->category }}</dd>
                                    </div>
                                    @endif
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Dipublikasikan</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $document->created_at->format('d F Y') }}</dd>
                                    </div>
                                </dl>
                            </div>

                        </div>

                    </div>


                    @if($relatedDocuments && $relatedDocuments->count() > 0)
                    <div class="mt-10">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Dokumen Terkait</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($relatedDocuments as $related)
                                @include('components.public.document-card', ['document' => $related])
                            @endforeach
                        </div>
                    </div>
                    @endif

                </article>


                <aside class="lg:col-span-1">
                    <div class="sticky top-4 space-y-6">


                        <a href="{{ route('documents') }}"
                           class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Dokumen
                        </a>


                        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl shadow-lg p-6 text-white">
                            <h4 class="font-semibold text-lg mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Aksi Cepat
                            </h4>
                            <div class="space-y-3">
                                @if($canPreview)
                                <a href="{{ route('documents.preview', $document->id) }}"
                                   target="_blank"
                                   class="block w-full bg-white text-blue-700 hover:bg-blue-50 rounded-lg px-4 py-2.5 text-center font-semibold transition-all duration-200 shadow-sm hover:shadow-md">
                                    👁️ Pratinjau
                                </a>
                                @endif
                                <a href="{{ route('documents.download', $document->id) }}"
                                   class="block w-full bg-white text-blue-700 hover:bg-blue-50 rounded-lg px-4 py-2.5 text-center font-semibold transition-all duration-200 shadow-sm hover:shadow-md">
                                    ⬇️ Unduh
                                </a>
                            </div>
                        </div>

                        
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <h4 class="font-semibold text-blue-900 mb-2">Informasi</h4>
                                    <p class="text-sm text-blue-800 leading-relaxed">
                                        @if($canPreview)
                                            Klik "Lihat Dokumen" untuk melihat preview di browser, atau "Unduh Dokumen" untuk menyimpan file.
                                        @else
                                            Klik "Unduh Dokumen" untuk mengunduh dan membuka file di perangkat Anda.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </aside>

            </div>

        </div>
    </section>

</x-public-layout>
