@props(['documentPath', 'title' => 'Dokumen'])

@php
    $extension = strtolower(pathinfo($documentPath, PATHINFO_EXTENSION));
    $fileName = basename($documentPath);
    $fileSize = Storage::exists($documentPath) ? Storage::size($documentPath) : 0;
    $fileSizeFormatted = $fileSize > 0 ? number_format($fileSize / 1024 / 1024, 2) . ' MB' : 'Unknown';
    
    // Icon and color based on file type
    $iconConfig = [
        'pdf' => ['color' => 'red', 'icon' => 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z'],
        'doc' => ['color' => 'blue', 'icon' => 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z'],
        'docx' => ['color' => 'blue', 'icon' => 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z'],
        'xls' => ['color' => 'green', 'icon' => 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z'],
        'xlsx' => ['color' => 'green', 'icon' => 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z'],
        'ppt' => ['color' => 'orange', 'icon' => 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z'],
        'pptx' => ['color' => 'orange', 'icon' => 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z'],
        'zip' => ['color' => 'purple', 'icon' => 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z'],
        'rar' => ['color' => 'purple', 'icon' => 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z'],
    ];
    
    $config = $iconConfig[$extension] ?? ['color' => 'gray', 'icon' => 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z'];
    
    $colorClasses = [
        'red' => 'bg-red-50 border-red-200 hover:bg-red-100 text-red-700',
        'blue' => 'bg-blue-50 border-blue-200 hover:bg-blue-100 text-blue-700',
        'green' => 'bg-green-50 border-green-200 hover:bg-green-100 text-green-700',
        'orange' => 'bg-orange-50 border-orange-200 hover:bg-orange-100 text-orange-700',
        'purple' => 'bg-purple-50 border-purple-200 hover:bg-purple-100 text-purple-700',
        'gray' => 'bg-gray-50 border-gray-200 hover:bg-gray-100 text-gray-700',
    ];
    
    $buttonColorClasses = [
        'red' => 'bg-red-600 hover:bg-red-700',
        'blue' => 'bg-blue-600 hover:bg-blue-700',
        'green' => 'bg-green-600 hover:bg-green-700',
        'orange' => 'bg-orange-600 hover:bg-orange-700',
        'purple' => 'bg-purple-600 hover:bg-purple-700',
        'gray' => 'bg-gray-600 hover:bg-gray-700',
    ];
@endphp

<!-- Document Card -->
<div class="border-2 rounded-xl {{ $colorClasses[$config['color']] }} transition-all duration-200">
    <div class="p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
            
            <!-- Icon -->
            <div class="flex-shrink-0">
                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-white shadow-sm flex items-center justify-center">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 {{ 'text-' . $config['color'] . '-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"></path>
                    </svg>
                </div>
            </div>
            
            <!-- Info -->
            <div class="flex-1 min-w-0">
                <h4 class="text-base sm:text-lg font-semibold text-gray-900 mb-1 truncate">
                    {{ Str::limit($title, 50) }}
                </h4>
                <div class="flex flex-wrap items-center gap-3 text-xs sm:text-sm text-gray-600">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium {{ 'bg-' . $config['color'] . '-100 text-' . $config['color'] . '-800' }}">
                        {{ strtoupper($extension) }}
                    </span>
                    @if($fileSize > 0)
                    <span class="inline-flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        {{ $fileSizeFormatted }}
                    </span>
                    @endif
                </div>
                <p class="mt-2 text-xs sm:text-sm text-gray-500 truncate">
                    {{ $fileName }}
                </p>
            </div>
            
            <!-- Download Button -->
            <div class="w-full sm:w-auto flex-shrink-0">
                <a href="{{ Storage::url($documentPath) }}" 
                   download
                   class="inline-flex items-center justify-center w-full sm:w-auto px-4 sm:px-6 py-2.5 sm:py-3 {{ $buttonColorClasses[$config['color']] }} text-white text-sm font-semibold rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    <span class="hidden sm:inline">Download</span>
                    <span class="sm:hidden">Unduh Dokumen</span>
                </a>
            </div>
            
        </div>
    </div>
</div>
