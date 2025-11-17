@props(['gallery'])

<div class="group relative overflow-hidden rounded-xl bg-white shadow-md hover:shadow-xl transition-all duration-300 cursor-pointer"
     x-data="{ showModal: false }"
     @click="showModal = true">
    <!-- Image Container -->
    <div class="aspect-square overflow-hidden bg-gray-100">
        @if($gallery->image)
            <img src="{{ Storage::url($gallery->image) }}"
                 alt="{{ $gallery->title }}"
                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"
                 loading="lazy">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        @endif

        <!-- Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <div class="absolute bottom-0 left-0 right-0 p-4 text-white transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                <div class="flex items-center gap-2 text-sm mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <span>Klik untuk melihat</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Info -->
    <div class="p-4">
        <h3 class="font-semibold text-gray-900 mb-1 line-clamp-2">{{ $gallery->title }}</h3>
        @if($gallery->description)
            <p class="text-sm text-gray-600 line-clamp-2 mb-2">{{ $gallery->description }}</p>
        @endif
        <div class="flex items-center text-xs text-gray-500">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            {{ $gallery->created_at->format('d M Y') }}
        </div>
    </div>

    <!-- Lightbox Modal -->
    <div x-show="showModal"
         x-cloak
         @click.stop="showModal = false"
         @keydown.escape.window="showModal = false"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 lg:p-8 bg-black/95"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <!-- Close Button -->
        <button @click.stop="showModal = false"
                class="absolute top-4 right-4 z-20 bg-white/10 hover:bg-white/20 rounded-full p-2 text-white hover:text-gray-200 transition-all duration-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <!-- Modal Content Container -->
        <div @click.stop class="w-full max-w-5xl mx-auto flex flex-col items-center">
            <!-- Image Container with max dimensions -->
            @if($gallery->image)
                <div class="relative w-full flex items-center justify-center mb-6">
                    <img src="{{ Storage::url($gallery->image) }}"
                         alt="{{ $gallery->title }}"
                         class="max-w-full max-h-[70vh] w-auto h-auto object-contain rounded-lg shadow-2xl"
                         style="max-height: 70vh;">
                </div>
            @endif

            <!-- Info Card below image -->
            <div class="bg-gray-900/90 backdrop-blur-md rounded-lg px-6 py-4 max-w-2xl w-full shadow-xl border border-white/10">
                <h3 class="text-lg sm:text-xl font-semibold text-white mb-2 drop-shadow-lg">{{ $gallery->title }}</h3>
                @if($gallery->description)
                    <p class="text-gray-200 text-sm mb-3 line-clamp-3 drop-shadow">{{ $gallery->description }}</p>
                @endif
                <div class="flex items-center text-xs text-gray-300">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ $gallery->created_at->format('d F Y') }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
