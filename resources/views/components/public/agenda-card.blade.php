@props(['agenda'])

@php
    $startDate = \Carbon\Carbon::parse($agenda->start_date);
    $endDate = \Carbon\Carbon::parse($agenda->end_date);
    $now = \Carbon\Carbon::now();

    // Determine status
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

<!-- Agenda Card Component -->
<article class="bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden group">

    <div class="flex flex-col sm:flex-row">

        <!-- Date Badge Section -->
        <div class="sm:w-32 flex-shrink-0 bg-gradient-to-br from-blue-600 to-indigo-700 text-white p-6 flex flex-col items-center justify-center text-center">
            <div class="text-4xl font-bold leading-none">{{ $startDate->format('d') }}</div>
            <div class="text-sm font-semibold mt-1 uppercase">{{ $startDate->format('M') }}</div>
            <div class="text-xs mt-1 opacity-90">{{ $startDate->format('Y') }}</div>

            @if($startDate->format('Y-m-d') !== $endDate->format('Y-m-d'))
                <div class="w-8 border-t border-white/30 my-2"></div>
                <div class="text-lg font-bold leading-none">{{ $endDate->format('d') }}</div>
                <div class="text-xs uppercase">{{ $endDate->format('M Y') }}</div>
            @endif
        </div>

        <!-- Content Section -->
        <div class="flex-1 p-5 sm:p-6">

            <!-- Status Badge -->
            <div class="mb-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                    {{ $status === 'upcoming' ? 'bg-blue-100 text-blue-800' : '' }}
                    {{ $status === 'ongoing' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $status === 'completed' ? 'bg-gray-100 text-gray-800' : '' }}">
                    <span class="w-2 h-2 rounded-full mr-2
                        {{ $status === 'upcoming' ? 'bg-blue-600' : '' }}
                        {{ $status === 'ongoing' ? 'bg-green-600 animate-pulse' : '' }}
                        {{ $status === 'completed' ? 'bg-gray-600' : '' }}"></span>
                    {{ $statusLabel }}
                </span>
            </div>

            <!-- Title -->
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors duration-200">
                <a href="{{ route('agenda.show', $agenda->id) }}">
                    {{ $agenda->title }}
                </a>
            </h3>

            <!-- Description -->
            @if($agenda->description)
            <p class="text-gray-600 text-sm sm:text-base mb-4 line-clamp-2">
                {{ Str::limit(strip_tags($agenda->description), 150) }}
            </p>
            @endif

            <!-- Meta Info -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-gray-600 mb-4">

                <!-- Time -->
                @if($agenda->start_time)
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ \Carbon\Carbon::parse($agenda->start_time)->format('H:i') }}
                        @if($agenda->end_time)
                            - {{ \Carbon\Carbon::parse($agenda->end_time)->format('H:i') }}
                        @endif
                        WIB
                    </span>
                </div>
                @endif

                <!-- Location -->
                @if($agenda->location)
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="truncate">{{ $agenda->location }}</span>
                </div>
                @endif

            </div>

            <!-- View Details Button -->
            <a href="{{ route('agenda.show', $agenda->id) }}"
               class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold text-sm sm:text-base group/link">
                Lihat Detail
                <svg class="w-4 h-4 ml-2 group-hover/link:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>

        </div>

    </div>

</article>
