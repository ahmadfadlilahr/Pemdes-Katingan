@props(['document'])

@php
    // Determine icon based on file type
    $iconClass = match(strtolower($document->file_type ?? 'pdf')) {
        'pdf' => 'text-red-600',
        'doc', 'docx' => 'text-blue-600',
        'xls', 'xlsx' => 'text-green-600',
        'ppt', 'pptx' => 'text-orange-600',
        'zip', 'rar' => 'text-purple-600',
        default => 'text-gray-600',
    };

    $iconPath = match(strtolower($document->file_type ?? 'pdf')) {
        'pdf' => 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z',
        'doc', 'docx' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
        'xls', 'xlsx' => 'M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z',
        'zip', 'rar' => 'M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4',
        default => 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z',
    };
@endphp

<!-- Document Card Component -->
<article class="bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden group border border-gray-100">

    <div class="p-6">

        <!-- Icon & Type -->
        <div class="flex items-start justify-between mb-4">
            <div class="flex-shrink-0 w-14 h-14 bg-gray-50 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-8 h-8 {{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"></path>
                </svg>
            </div>

            <!-- File Type Badge -->
            @if($document->file_type)
            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold uppercase
                {{ $document->file_type === 'pdf' ? 'bg-red-100 text-red-800' : '' }}
                {{ in_array($document->file_type, ['doc', 'docx']) ? 'bg-blue-100 text-blue-800' : '' }}
                {{ in_array($document->file_type, ['xls', 'xlsx']) ? 'bg-green-100 text-green-800' : '' }}
                {{ in_array($document->file_type, ['ppt', 'pptx']) ? 'bg-orange-100 text-orange-800' : '' }}
                {{ in_array($document->file_type, ['zip', 'rar']) ? 'bg-purple-100 text-purple-800' : '' }}
                {{ !in_array($document->file_type, ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'rar']) ? 'bg-gray-100 text-gray-800' : '' }}">
                {{ strtoupper($document->file_type) }}
            </span>
            @endif
        </div>

        <!-- Title -->
        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors duration-200">
            <a href="{{ route('documents.show', $document->id) }}">
                {{ $document->title }}
            </a>
        </h3>

        <!-- Description -->
        @if($document->description)
        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
            {{ Str::limit(strip_tags($document->description), 120) }}
        </p>
        @endif

        <!-- Category -->
        @if($document->category)
        <div class="mb-4">
            <span class="inline-flex items-center text-xs text-gray-600">
                <svg class="w-4 h-4 mr-1.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                {{ $document->category }}
            </span>
        </div>
        @endif

        <!-- Meta Info -->
        <div class="flex items-center justify-between text-xs text-gray-500 mb-5 pt-4 border-t border-gray-100">
            <!-- File Size -->
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                </svg>
                {{ $document->file_size_formatted ?? '0 KB' }}
            </div>

            <!-- Download Count -->
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                {{ $document->download_count ?? 0 }} unduhan
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="grid grid-cols-2 gap-2">
            <!-- View Details Button -->
            <a href="{{ route('documents.show', $document->id) }}"
               class="inline-flex items-center justify-center px-3 py-2 bg-white border-2 border-blue-600 text-blue-600 rounded-lg font-semibold text-sm hover:bg-blue-50 transition-all duration-200 group/view">
                <svg class="w-4 h-4 mr-1.5 group-hover/view:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Lihat
            </a>

            <!-- Download Button -->
            <a href="{{ route('documents.download', $document->id) }}"
               class="inline-flex items-center justify-center px-3 py-2 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-lg font-semibold text-sm hover:from-blue-700 hover:to-indigo-800 transition-all duration-200 shadow-md hover:shadow-lg group/btn">
                <svg class="w-4 h-4 mr-1.5 group-hover/btn:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Unduh
            </a>
        </div>

    </div>

</article>
