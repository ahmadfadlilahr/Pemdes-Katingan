@props(['upcomingAgenda'])

<!-- Upcoming Agenda Sidebar Component -->
<div class="bg-white rounded-xl shadow-md p-6">

    <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center">
        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        Agenda Mendatang
    </h3>

    @if($upcomingAgenda && $upcomingAgenda->count() > 0)
        <div class="space-y-4">
            @foreach($upcomingAgenda as $agenda)
                @php
                    $startDate = \Carbon\Carbon::parse($agenda->start_date);
                @endphp

                <article class="group">
                    <a href="{{ route('agenda.show', $agenda->id) }}"
                       class="flex gap-3 hover:bg-gray-50 p-3 rounded-lg transition-colors duration-200">

                        <!-- Date Badge Mini -->
                        <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-blue-600 to-indigo-700 text-white rounded-lg flex flex-col items-center justify-center">
                            <div class="text-xl font-bold leading-none">{{ $startDate->format('d') }}</div>
                            <div class="text-xs mt-1 uppercase">{{ $startDate->format('M') }}</div>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-semibold text-gray-900 line-clamp-2 group-hover:text-blue-600 transition-colors duration-200 mb-2">
                                {{ $agenda->title }}
                            </h4>

                            <!-- Time -->
                            @if($agenda->start_time)
                            <div class="flex items-center text-xs text-gray-500 mb-1">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ \Carbon\Carbon::parse($agenda->start_time)->format('H:i') }} WIB
                            </div>
                            @endif

                            <!-- Location -->
                            @if($agenda->location)
                            <div class="flex items-center text-xs text-gray-500">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="truncate">{{ Str::limit($agenda->location, 30) }}</span>
                            </div>
                            @endif
                        </div>

                    </a>
                </article>

                @if(!$loop->last)
                    <hr class="border-gray-200">
                @endif
            @endforeach
        </div>
    @else
        <p class="text-gray-500 text-sm text-center py-4">Belum ada agenda mendatang</p>
    @endif

</div>
