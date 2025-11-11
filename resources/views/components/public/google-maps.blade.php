@props(['embedCode'])

@php
/**
 * Component untuk menampilkan Google Maps embed
 * Mendukung input berupa:
 * 1. Full iframe HTML
 * 2. URL embed saja
 * 3. Handling error jika format tidak valid
 */

$mapUrl = null;

if (!empty($embedCode)) {
    // Check if it's a full iframe HTML
    if (str_contains($embedCode, '<iframe')) {
        // Extract src URL from iframe
        preg_match('/src=["\']([^"\']+)["\']/', $embedCode, $matches);
        if (isset($matches[1])) {
            $mapUrl = $matches[1];
        }
    }
    // Check if it's already a valid URL
    elseif (str_starts_with($embedCode, 'http') || str_starts_with($embedCode, '//')) {
        $mapUrl = $embedCode;
    }
    // Check if it's a URL without protocol
    elseif (str_contains($embedCode, 'google.com/maps')) {
        $mapUrl = 'https://' . ltrim($embedCode, '/');
    }
}
@endphp

@if($mapUrl)
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="relative w-full" style="padding-bottom: 56.25%; /* 16:9 aspect ratio */">
            <iframe
                src="{{ $mapUrl }}"
                class="absolute top-0 left-0 w-full h-full"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="Lokasi Kantor">
            </iframe>
        </div>

        {{-- Optional: Add "View in Google Maps" link --}}
        @if(str_contains($mapUrl, 'google.com/maps/embed'))
            @php
                // Extract place ID or coordinates for full maps link
                $fullMapUrl = str_replace('/embed?', '/place/?', $mapUrl);
                $fullMapUrl = str_replace('embed', 'place', $mapUrl);
            @endphp
            <div class="p-4 bg-gray-50 border-t border-gray-200">
                <a href="{{ $fullMapUrl }}"
                   target="_blank"
                   class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    Buka di Google Maps
                </a>
            </div>
        @endif
    </div>
@else
    {{-- Fallback jika tidak ada maps atau format invalid --}}
    <div class="bg-gray-50 rounded-lg border-2 border-dashed border-gray-300 p-8">
        <div class="text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
            </svg>
            <p class="mt-2 text-sm text-gray-600">Lokasi belum tersedia</p>
        </div>
    </div>
@endif
