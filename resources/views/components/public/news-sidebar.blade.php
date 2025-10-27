@props(['latestNews'])

<!-- Latest News Sidebar Component -->
<div class="bg-white rounded-xl shadow-md p-6">

    <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center">
        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        Berita Terbaru
    </h3>

    @if($latestNews && $latestNews->count() > 0)
        <div class="space-y-4">
            @foreach($latestNews as $news)
                <article class="group">
                    <a href="{{ route('news.show', $news->slug) }}" class="flex gap-3 hover:bg-gray-50 p-2 rounded-lg transition-colors duration-200">

                        <!-- Thumbnail -->
                        <div class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden bg-gradient-to-br from-blue-50 to-indigo-50">
                            @if($news->image)
                                <img src="{{ Storage::url($news->image) }}"
                                     alt="{{ $news->title }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-semibold text-gray-900 line-clamp-2 group-hover:text-blue-600 transition-colors duration-200 mb-1">
                                {{ $news->title }}
                            </h4>
                            <div class="flex items-center text-xs text-gray-500">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ \Carbon\Carbon::parse($news->published_at)->format('d M Y') }}
                            </div>
                        </div>

                    </a>
                </article>

                @if(!$loop->last)
                    <hr class="border-gray-200">
                @endif
            @endforeach
        </div>
    @else
        <p class="text-gray-500 text-sm text-center py-4">Belum ada berita terbaru</p>
    @endif

</div>
