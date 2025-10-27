<x-public-layout :title="$news->title . ' - Dinas PMD Kabupaten Katingan'" :description="Str::limit(strip_tags($news->content), 160)">

    <!-- Page Header -->
    @include('components.public.page-header', [
        'title' => 'Detail Berita',
        'subtitle' => null,
        'breadcrumbs' => [
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Berita', 'url' => route('news')],
            ['label' => Str::limit($news->title, 30), 'url' => null]
        ]
    ])

    <!-- Main Content -->
    <section class="py-12 sm:py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10">

                <!-- Main Article -->
                <article class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">

                        <!-- Featured Image -->
                        @if($news->image)
                        <div class="relative h-64 sm:h-96 overflow-hidden bg-gradient-to-br from-blue-50 to-indigo-50">
                            <img src="{{ Storage::url($news->image) }}"
                                 alt="{{ $news->title }}"
                                 class="w-full h-full object-cover">
                        </div>
                        @endif

                        <!-- Article Content -->
                        <div class="p-6 sm:p-8 lg:p-10">

                            <!-- Meta Info -->
                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-6 pb-6 border-b border-gray-200">
                                <!-- Date -->
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>{{ \Carbon\Carbon::parse($news->published_at)->format('d F Y') }}</span>
                                </div>

                                <!-- Author -->
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span>{{ $news->user->name ?? 'Admin' }}</span>
                                </div>
                            </div>

                            <!-- Title -->
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-6 leading-tight">
                                {{ $news->title }}
                            </h1>

                            <!-- Content -->
                            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                                {!! $news->content !!}
                            </div>

                            <!-- Share Buttons -->
                            <div class="mt-10 pt-6 border-t border-gray-200">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4">Bagikan Berita Ini:</h4>
                                <div class="flex flex-wrap gap-3">
                                    <!-- Facebook -->
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                                       target="_blank"
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                        Facebook
                                    </a>

                                    <!-- Twitter -->
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($news->title) }}"
                                       target="_blank"
                                       class="inline-flex items-center px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                        </svg>
                                        Twitter
                                    </a>

                                    <!-- WhatsApp -->
                                    <a href="https://api.whatsapp.com/send?text={{ urlencode($news->title . ' - ' . request()->fullUrl()) }}"
                                       target="_blank"
                                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                        </svg>
                                        WhatsApp
                                    </a>
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- Related News -->
                    @if($relatedNews && $relatedNews->count() > 0)
                    <div class="mt-10">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Berita Terkait</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach($relatedNews as $related)
                                @include('components.public.news-card', ['news' => $related])
                            @endforeach
                        </div>
                    </div>
                    @endif

                </article>

                <!-- Sidebar -->
                <aside class="lg:col-span-1">
                    <div class="sticky top-4 space-y-6">

                        <!-- Back to News -->
                        <a href="{{ route('news') }}"
                           class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Berita
                        </a>

                        <!-- Latest News Sidebar -->
                        @include('components.public.news-sidebar', [
                            'latestNews' => \App\Models\News::where('is_published', true)
                                ->where('id', '!=', $news->id)
                                ->orderBy('published_at', 'desc')
                                ->take(5)
                                ->get()
                        ])

                    </div>
                </aside>

            </div>

        </div>
    </section>

</x-public-layout>
