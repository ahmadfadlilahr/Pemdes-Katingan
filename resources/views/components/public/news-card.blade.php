@props(['news'])

<!-- News Card Component -->
<article class="bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden group">

    <!-- Image Section -->
    <div class="relative h-48 sm:h-56 overflow-hidden bg-gradient-to-br from-blue-50 to-indigo-50">

        @if($news->image)
            <img src="{{ Storage::url($news->image) }}"
                 alt="{{ $news->title }}"
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
        @else
            <!-- Default Image with Icon -->
            <div class="w-full h-full flex items-center justify-center">
                <svg class="w-20 h-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
            </div>
        @endif

        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 via-transparent to-transparent"></div>

        <!-- Date Badge -->
        <div class="absolute top-4 left-4">
            <div class="bg-blue-600 text-white px-3 py-1.5 rounded-lg shadow-lg">
                <div class="text-xs font-semibold">
                    {{ \Carbon\Carbon::parse($news->published_at)->format('d M Y') }}
                </div>
            </div>
        </div>

    </div>

    <!-- Content Section -->
    <div class="p-5 sm:p-6">

        <!-- Meta Info -->
        <div class="flex items-center text-sm text-gray-500 mb-3 space-x-4">
            <!-- Author -->
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span>{{ $news->user->name ?? 'Admin' }}</span>
            </div>

            <!-- Views (if you have view count) -->
            {{-- <div class="flex items-center">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <span>{{ $news->views ?? 0 }}</span>
            </div> --}}
        </div>

        <!-- Title -->
        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors duration-200">
            <a href="{{ route('news.show', $news->slug) }}">
                {{ $news->title }}
            </a>
        </h3>

        <!-- Excerpt -->
        <p class="text-gray-600 text-sm sm:text-base mb-4 line-clamp-3">
            {{ Str::limit(strip_tags($news->content), 120) }}
        </p>

        <!-- Read More Button -->
        <a href="{{ route('news.show', $news->slug) }}"
           class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold text-sm sm:text-base group/link">
            Baca Selengkapnya
            <svg class="w-4 h-4 ml-2 group-hover/link:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>

    </div>

</article>
