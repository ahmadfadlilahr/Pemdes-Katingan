@props(['title', 'value', 'icon', 'color' => 'blue'])

@php
    $colors = [
        'green' => [
            'bg' => 'bg-green-500',
            'icon' => 'bg-green-100',
            'text' => 'text-green-600'
        ],
        'blue' => [
            'bg' => 'bg-blue-500',
            'icon' => 'bg-blue-100',
            'text' => 'text-blue-600'
        ],
        'orange' => [
            'bg' => 'bg-orange-500',
            'icon' => 'bg-orange-100',
            'text' => 'text-orange-600'
        ],
        'purple' => [
            'bg' => 'bg-purple-500',
            'icon' => 'bg-purple-100',
            'text' => 'text-purple-600'
        ],
        'red' => [
            'bg' => 'bg-red-500',
            'icon' => 'bg-red-100',
            'text' => 'text-red-600'
        ],
    ];

    $selectedColor = $colors[$color] ?? $colors['blue'];

    $icons = [
        'newspaper' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z',
        'photo' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z',
        'clock' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
        'calendar' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
        'users' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
    ];

    $iconPath = $icons[$icon] ?? $icons['newspaper'];
@endphp

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-200">
    <div class="p-6">
        <div class="flex items-center justify-between">
            <!-- Icon & Content -->
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-14 h-14 {{ $selectedColor['icon'] }} rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 {{ $selectedColor['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"/>
                        </svg>
                    </div>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">{{ $title }}</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $value }}</p>
                </div>
            </div>

            <!-- Decorative Element -->
            <div class="hidden sm:block">
                <div class="w-16 h-16 {{ $selectedColor['bg'] }} rounded-full opacity-10"></div>
            </div>
        </div>
    </div>

    <!-- Bottom Accent -->
    <div class="h-1 {{ $selectedColor['bg'] }}"></div>
</div>
