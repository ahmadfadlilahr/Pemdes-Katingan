@props(['structure', 'index', 'totalInLevel', 'level'])

@php
    // Animation delay
    $delay = ($index % 4) * 100;
@endphp

<div class="organization-card-hierarchical w-full max-w-xs"
     data-aos="fade-up"
     data-aos-delay="{{ $delay }}">

    <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 group flex flex-col">

        <!-- Photo Section - Portrait Style dengan Aspect Ratio -->
        <div class="relative w-full aspect-[3/4] bg-gradient-to-br from-blue-50 to-indigo-50 overflow-hidden flex-shrink-0">

            <!-- Decorative Background -->
            <div class="absolute inset-0 opacity-30">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-200 rounded-full filter blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-40 h-40 bg-indigo-200 rounded-full filter blur-3xl"></div>
            </div>

            <!-- Photo -->
            @if($structure->photo)
                <img src="{{ Storage::url($structure->photo) }}"
                     alt="{{ $structure->name }}"
                     class="absolute inset-0 w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500"
                     loading="lazy">
            @else
                <!-- Default Avatar -->
                <div class="absolute inset-0 w-full h-full flex items-center justify-center">
                    <svg class="w-24 h-24 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            @endif

            <!-- Gradient Overlay -->
            <div class="absolute bottom-0 left-0 right-0 h-1/3 bg-gradient-to-t from-gray-900/60 to-transparent"></div>
        </div>

        <!-- Info Section - Compact & Clean -->
        <div class="p-5 text-center flex-grow flex flex-col justify-center">

            <!-- Position Badge - Blue Gradient -->
            <div class="mb-3 flex justify-center">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-md">
                    <svg class="w-3 h-3 mr-1.5 text-blue-200" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                    {{ $structure->position }}
                </span>
            </div>

            <!-- Name - Bold & Proportional -->
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 leading-tight line-clamp-2">
                {{ $structure->name }}
            </h3>

            <!-- NIP with Icon -->
            @if($structure->nip)
            <div class="flex items-center justify-center text-gray-600 text-xs sm:text-sm">
                <svg class="w-3.5 h-3.5 mr-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                </svg>
                <x-public.masked-nip :nip="$structure->nip" />
            </div>
            @endif

            <!-- Decorative Line - Subtle -->
            <div class="flex items-center justify-center mt-4 space-x-1.5">
                <div class="w-6 h-0.5 bg-gradient-to-r from-transparent via-blue-500 to-transparent rounded-full"></div>
                <div class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-pulse"></div>
                <div class="w-6 h-0.5 bg-gradient-to-r from-transparent via-blue-500 to-transparent rounded-full"></div>
            </div>

        </div>

        {{-- <!-- Hover Effect Border -->
        <div class="absolute inset-0 rounded-2xl border-2 border-transparent group-hover:border-blue-500/20 transition-all duration-300 pointer-events-none"></div> --}}

    </div>

</div>@once
@push('styles')
<style>
    .organization-card-hierarchical {
        animation: fadeInScale 0.6s ease-out forwards;
        opacity: 0;
    }

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.95) translateY(20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    /* Hierarchy Level Styles */
    .hierarchy-level {
        position: relative;
    }

    /* Connecting Line Animations */
    .hierarchy-level:not(:last-child)::after {
        content: '';
        position: absolute;
        bottom: -2rem;
        left: 50%;
        transform: translateX(-50%);
        width: 2px;
        height: 2rem;
        background: linear-gradient(to bottom, rgba(96, 165, 250, 0.3), rgba(96, 165, 250, 0));
    }

    /* Responsive Grid Adjustments */
    @media (max-width: 640px) {
        .organization-card-hierarchical {
            max-width: 100%;
        }
    }

    /* Print Styles */
    @media print {
        .organization-card-hierarchical {
            break-inside: avoid;
            page-break-inside: avoid;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Add smooth scroll behavior for hierarchy navigation
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.organization-card-hierarchical');

        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>
@endpush
@endonce
