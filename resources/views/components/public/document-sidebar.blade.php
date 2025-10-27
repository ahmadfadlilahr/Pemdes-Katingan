@props(['popularDocuments'])

<!-- Popular Documents Sidebar Component -->
<div class="bg-white rounded-xl shadow-md p-6">

    <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center">
        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
        </svg>
        Dokumen Populer
    </h3>

    @if($popularDocuments && $popularDocuments->count() > 0)
        <div class="space-y-4">
            @foreach($popularDocuments as $doc)
                @php
                    $iconClass = match(strtolower($doc->file_type ?? 'pdf')) {
                        'pdf' => 'text-red-600',
                        'doc', 'docx' => 'text-blue-600',
                        'xls', 'xlsx' => 'text-green-600',
                        default => 'text-gray-600',
                    };
                @endphp

                <article class="group">
                    <div class="flex gap-3 hover:bg-gray-50 p-3 rounded-lg transition-colors duration-200">

                        <!-- Icon -->
                        <div class="flex-shrink-0 w-12 h-12 bg-gray-50 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 {{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-semibold text-gray-900 line-clamp-2 group-hover:text-blue-600 transition-colors duration-200 mb-2">
                                {{ $doc->title }}
                            </h4>

                            <!-- Meta -->
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    {{ $doc->download_count ?? 0 }}x
                                </span>
                                <span class="uppercase font-semibold {{ $iconClass }}">
                                    {{ $doc->file_type }}
                                </span>
                            </div>

                            <!-- Download Link -->
                            <a href="{{ route('documents.download', $doc->id) }}"
                               class="inline-flex items-center text-xs text-blue-600 hover:text-blue-700 font-semibold mt-2">
                                Unduh
                                <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </a>
                        </div>

                    </div>
                </article>

                @if(!$loop->last)
                    <hr class="border-gray-200">
                @endif
            @endforeach
        </div>
    @else
        <p class="text-gray-500 text-sm text-center py-4">Belum ada dokumen populer</p>
    @endif

</div>
