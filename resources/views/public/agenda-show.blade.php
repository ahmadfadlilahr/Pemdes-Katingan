<x-public-layout :title="$agenda->title . ' - Dinas PMD Kabupaten Katingan'" :description="Str::limit(strip_tags($agenda->description), 160)">

    <!-- Page Header -->
    @include('components.public.page-header', [
        'title' => 'Detail Agenda',
        'subtitle' => null,
        'breadcrumbs' => [
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Agenda', 'url' => route('agenda')],
            ['label' => Str::limit($agenda->title, 30), 'url' => null]
        ]
    ])

    <!-- Main Content -->
    <section class="py-12 sm:py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10">

                <!-- Main Content -->
                <article class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">

                        @php
                            $startDate = \Carbon\Carbon::parse($agenda->start_date);
                            $endDate = \Carbon\Carbon::parse($agenda->end_date);
                            $now = \Carbon\Carbon::now();

                            if ($startDate->isFuture()) {
                                $status = 'upcoming';
                                $statusLabel = 'Akan Datang';
                                $statusColor = 'blue';
                            } elseif ($endDate->isPast()) {
                                $status = 'completed';
                                $statusLabel = 'Selesai';
                                $statusColor = 'gray';
                            } else {
                                $status = 'ongoing';
                                $statusLabel = 'Sedang Berlangsung';
                                $statusColor = 'green';
                            }
                        @endphp

                        <!-- Header Info -->
                        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 text-white p-6 sm:p-8">

                            <!-- Status Badge -->
                            <div class="mb-4">
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-white/20 backdrop-blur-sm">
                                    <span class="w-2 h-2 rounded-full mr-2 bg-white {{ $status === 'ongoing' ? 'animate-pulse' : '' }}"></span>
                                    {{ $statusLabel }}
                                </span>
                            </div>

                            <!-- Title -->
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-6">
                                {{ $agenda->title }}
                            </h1>

                            <!-- Date & Time Info Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                                <!-- Start Date -->
                                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
                                    <div class="text-xs uppercase tracking-wide mb-1 opacity-80">Tanggal Mulai</div>
                                    <div class="text-xl font-bold">{{ $startDate->format('d F Y') }}</div>
                                    @if($agenda->start_time)
                                        <div class="text-sm mt-1">Pukul {{ \Carbon\Carbon::parse($agenda->start_time)->format('H:i') }} WIB</div>
                                    @endif
                                </div>

                                <!-- End Date -->
                                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
                                    <div class="text-xs uppercase tracking-wide mb-1 opacity-80">Tanggal Selesai</div>
                                    <div class="text-xl font-bold">{{ $endDate->format('d F Y') }}</div>
                                    @if($agenda->end_time)
                                        <div class="text-sm mt-1">Pukul {{ \Carbon\Carbon::parse($agenda->end_time)->format('H:i') }} WIB</div>
                                    @endif
                                </div>

                            </div>

                        </div>

                        <!-- Content Section -->
                        <div class="p-6 sm:p-8 lg:p-10">

                            <!-- Location -->
                            @if($agenda->location)
                            <div class="mb-6 pb-6 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Lokasi
                                </h3>
                                <p class="text-gray-700">{{ $agenda->location }}</p>
                            </div>
                            @endif

                            <!-- Description -->
                            @if($agenda->description)
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Deskripsi Kegiatan</h3>
                                <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                                    {!! $agenda->description !!}
                                </div>
                            </div>
                            @endif

                            <!-- Share Buttons -->
                            <div class="mt-10 pt-6 border-t border-gray-200">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4">Bagikan Agenda Ini:</h4>
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

                                    <!-- WhatsApp -->
                                    <a href="https://api.whatsapp.com/send?text={{ urlencode($agenda->title . ' - ' . request()->fullUrl()) }}"
                                       target="_blank"
                                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                        </svg>
                                        WhatsApp
                                    </a>

                                    <!-- Twitter -->
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($agenda->title) }}"
                                       target="_blank"
                                       class="inline-flex items-center px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                        </svg>
                                        Twitter
                                    </a>
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- Related Agenda -->
                    @if($relatedAgenda && $relatedAgenda->count() > 0)
                    <div class="mt-10">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Agenda Terkait</h3>
                        <div class="space-y-6">
                            @foreach($relatedAgenda as $related)
                                @include('components.public.agenda-card', ['agenda' => $related])
                            @endforeach
                        </div>
                    </div>
                    @endif

                </article>

                <!-- Sidebar -->
                <aside class="lg:col-span-1">
                    <div class="sticky top-4 space-y-6">

                        <!-- Back to Agenda -->
                        <a href="{{ route('agenda') }}"
                           class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Agenda
                        </a>

                        <!-- Upcoming Agenda Sidebar -->
                        @include('components.public.agenda-sidebar', [
                            'upcomingAgenda' => \App\Models\Agenda::where('is_active', true)
                                ->where('id', '!=', $agenda->id)
                                ->where('start_date', '>=', now()->toDateString())
                                ->orderBy('start_date', 'asc')
                                ->take(5)
                                ->get()
                        ])

                    </div>
                </aside>

            </div>

        </div>
    </section>

</x-public-layout>
