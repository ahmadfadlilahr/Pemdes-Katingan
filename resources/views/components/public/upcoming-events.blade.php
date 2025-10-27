<!-- Upcoming Events Section -->
<div class="mb-6 sm:mb-8">
    <div class="flex items-center justify-between">
        <h3 class="text-xl sm:text-2xl font-bold text-gray-900">Agenda Kegiatan</h3>
        <a href="{{ route('agenda') }}" class="text-green-600 hover:text-green-700 font-medium text-sm flex items-center group">
            Lihat Semua
            <svg class="ml-1 w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>
    <div class="w-16 sm:w-20 h-1 bg-green-600 mt-2"></div>
</div>

@if($upcomingAgenda && $upcomingAgenda->count() > 0)
    <div class="space-y-3 sm:space-y-4">
        @foreach($upcomingAgenda as $agenda)
        <div class="border border-gray-200 rounded-lg p-3 sm:p-4 hover:border-green-300 hover:shadow-md transition-all duration-200 cursor-pointer"
             onclick="window.location.href='{{ route('agenda') }}'">
            <div class="flex items-start space-x-3 sm:space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 bg-green-100 rounded-lg flex flex-col items-center justify-center">
                        <span class="text-xs text-green-600 font-medium uppercase">
                            {{ \Carbon\Carbon::parse($agenda->start_date)->format('M') }}
                        </span>
                        <span class="text-lg sm:text-xl font-bold text-green-700">
                            {{ \Carbon\Carbon::parse($agenda->start_date)->format('d') }}
                        </span>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm sm:text-base font-semibold text-gray-900 mb-1 line-clamp-2">
                        {{ $agenda->title }}
                    </h4>
                    @if($agenda->description)
                    <p class="text-xs sm:text-sm text-gray-600 mb-2 line-clamp-2">
                        {{ Str::limit(strip_tags($agenda->description), 100) }}
                    </p>
                    @endif
                    <div class="flex flex-col sm:flex-row sm:items-center text-xs text-gray-500 space-y-1 sm:space-y-0 sm:space-x-4">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="truncate">
                                {{ $agenda->start_time ? \Carbon\Carbon::parse($agenda->start_time)->format('H:i') : '' }}
                                @if($agenda->end_time)
                                - {{ \Carbon\Carbon::parse($agenda->end_time)->format('H:i') }}
                                @endif
                            </span>
                        </div>
                        @if($agenda->location)
                        <div class="flex items-center">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                            <span class="truncate">{{ Str::limit($agenda->location, 30) }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <!-- Empty State -->
    <div class="text-center py-12">
        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada agenda</h3>
        <p class="mt-2 text-sm text-gray-500">Agenda kegiatan mendatang akan ditampilkan di sini.</p>
    </div>
@endif
