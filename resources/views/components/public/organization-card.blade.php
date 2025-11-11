@props(['structure', 'index'])

@php
    // Determine card style based on position/order
    $isLeader = $index === 0; // First person is typically the leader
    $cardClass = $isLeader ? 'lg:col-span-2 lg:mx-auto lg:max-w-2xl' : '';

    // Animation delay
    $delay = ($index % 3) * 100;
@endphp

<div class="organization-card {{ $cardClass }}"
     data-aos="fade-up"
     data-aos-delay="{{ $delay }}">

    <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 group">

        <!-- Photo Section -->
        <div class="relative {{ $isLeader ? 'h-80 sm:h-96' : 'h-64 sm:h-72' }} bg-gradient-to-br from-blue-50 to-indigo-50 overflow-hidden">

            <!-- Decorative Background -->
            <div class="absolute inset-0 opacity-30">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-200 rounded-full filter blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-40 h-40 bg-indigo-200 rounded-full filter blur-3xl"></div>
            </div>

            <!-- Photo -->
            @if($structure->photo)
                <img src="{{ Storage::url($structure->photo) }}"
                     alt="{{ $structure->name }}"
                     class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
            @else
                <!-- Default Avatar -->
                <div class="w-full h-full flex items-center justify-center">
                    <svg class="w-32 h-32 {{ $isLeader ? 'sm:w-40 sm:h-40' : 'sm:w-36 sm:h-36' }} text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            @endif

            <!-- Gradient Overlay -->
            <div class="absolute bottom-0 left-0 right-0 h-1/3 bg-gradient-to-t from-gray-900/60 to-transparent"></div>
        </div>

        <!-- Info Section -->
        <div class="p-6 sm:p-8 {{ $isLeader ? 'text-center' : '' }}">

            <!-- Position Badge -->
            <div class="mb-4 {{ $isLeader ? 'flex justify-center' : '' }}">
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs sm:text-sm font-semibold {{ $isLeader ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white' : 'bg-blue-100 text-blue-800' }}">
                    {{ $structure->position }}
                </span>
            </div>

            <!-- Name -->
            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2 {{ $isLeader ? 'lg:text-3xl' : '' }}">
                {{ $structure->name }}
            </h3>

            <!-- NIP -->
            @if($structure->nip)
            <div class="flex items-center {{ $isLeader ? 'justify-center' : '' }} text-gray-600 text-sm sm:text-base">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                </svg>
                <x-public.masked-nip :nip="$structure->nip" />
            </div>
            @endif

            <!-- Decorative Line for Leader -->
            @if($isLeader)
            <div class="flex items-center justify-center mt-6 space-x-2">
                <div class="w-8 h-0.5 bg-blue-600 rounded-full"></div>
                <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                <div class="w-8 h-0.5 bg-blue-600 rounded-full"></div>
            </div>
            @endif

        </div>

    </div>

</div>

@once
@push('styles')
<style>
    .organization-card {
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush
@endonce
