<!-- Latest News Section -->
<div class="mb-6 sm:mb-8">
    <div class="flex items-center justify-between">
        <h3 class="text-xl sm:text-2xl font-bold text-gray-900">Berita Terbaru</h3>
        <a href="{{ route('news') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center group">
            Lihat Semua
            <svg class="ml-1 w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>
    <div class="w-16 sm:w-20 h-1 bg-blue-600 mt-2"></div>
</div>

@if($latestNews && $latestNews->count() > 0)
<div class="space-y-6">
        <!-- Featured News (First Item) -->
        @php $featuredNews = $latestNews->first(); @endphp
        <article class="group cursor-pointer" onclick="window.location.href='{{ route('news') }}'">
            <div class="bg-gray-200 rounded-lg h-40 sm:h-48 lg:h-56 mb-4 overflow-hidden">
                @if($featuredNews->image)
                <img src="{{ Storage::url($featuredNews->image) }}"
                     alt="{{ $featuredNews->title }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                @else
                <div class="w-full h-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                    <svg class="w-12 h-12 sm:w-16 sm:h-16 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path>
                    </svg>
                </div>
                @endif
            </div>
            <div class="space-y-2">
                @if($featuredNews->category)
                <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                    {{ $featuredNews->category }}
                </span>
                @endif
                <h4 class="text-base sm:text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200 line-clamp-2">
                    {{ $featuredNews->title }}
                </h4>
                <p class="text-sm text-gray-600 line-clamp-3">
                    {{ Str::limit(strip_tags($featuredNews->content), 150) }}
                </p>
                <div class="flex items-center text-xs text-gray-500 mt-3">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ $featuredNews->published_at ? $featuredNews->published_at->format('d M Y') : $featuredNews->created_at->format('d M Y') }}
                </div>
            </div>
        </article>

        <!-- News List (Remaining Items) -->
        @if($latestNews->count() > 1)
        <div class="space-y-3 sm:space-y-4 border-t border-gray-100 pt-4 sm:pt-6">
            @foreach($latestNews->skip(1) as $news)
            <article class="flex space-x-3 sm:space-x-4 group hover:bg-gray-50 p-2 sm:p-3 rounded-lg transition-colors duration-200 cursor-pointer"
                     onclick="window.location.href='{{ route('news') }}'">
                <div class="w-16 h-12 sm:w-20 sm:h-16 bg-gray-200 rounded-lg flex-shrink-0 overflow-hidden">
                    @if($news->image)
                    <img src="{{ Storage::url($news->image) }}"
                         alt="{{ $news->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path>
                        </svg>
                    </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <h5 class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200 line-clamp-2">
                        {{ $news->title }}
                    </h5>
                    <p class="text-xs text-gray-600 mt-1 line-clamp-2 hidden sm:block">
                        {{ Str::limit(strip_tags($news->content), 80) }}
                    </p>
                    <span class="text-xs text-gray-500 mt-1 sm:mt-2 block">
                        {{ $news->published_at ? $news->published_at->format('d M Y') : $news->created_at->format('d M Y') }}
                    </span>
                </div>
            </article>
            @endforeach
        </div>
        @endif
    </div>
    @else
    <!-- Empty State -->
    <div class="text-center py-12">
        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path>
        </svg>
        <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada berita</h3>
        <p class="mt-2 text-sm text-gray-500">Berita terbaru akan ditampilkan di sini.</p>
    </div>
@endif
