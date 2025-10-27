@props(['title', 'subtitle' => null, 'breadcrumbs' => []])

<!-- Page Header Section -->
<section class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 py-16 sm:py-20 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full filter blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
            <svg class="w-full h-full opacity-20" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#ffffff" d="M47.5,-57.3C59.3,-45.5,65.4,-28.2,67.2,-11.1C69,6,66.5,22.9,58.1,37.1C49.7,51.3,35.4,62.8,19.3,68.1C3.2,73.4,-14.7,72.5,-30.5,66.3C-46.3,60.1,-60,48.6,-67.5,33.8C-75,19,-76.3,0.9,-72.8,-15.7C-69.3,-32.3,-61,-47.4,-48.5,-59C-36,-70.6,-18,-78.7,-0.3,-78.3C17.4,-77.9,35.7,-69.1,47.5,-57.3Z" transform="translate(100 100)" />
            </svg>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 relative z-10">
        <!-- Breadcrumb -->
        @if(count($breadcrumbs) > 0)
        <nav class="mb-8">
            <ol class="flex justify-center items-center space-x-2 text-sm text-blue-100 flex-wrap">
                @foreach($breadcrumbs as $index => $breadcrumb)
                    <li class="flex items-center">
                        @if($breadcrumb['url'])
                            <a href="{{ $breadcrumb['url'] }}" class="hover:text-white transition-colors duration-200 flex items-center">
                                @if($index === 0)
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                @endif
                                {{ $breadcrumb['label'] }}
                            </a>
                        @else
                            <span class="text-white font-medium">{{ $breadcrumb['label'] }}</span>
                        @endif
                    </li>
                    @if($index < count($breadcrumbs) - 1)
                        <li>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </li>
                    @endif
                @endforeach
            </ol>
        </nav>
        @endif

        <!-- Title & Subtitle -->
        <div class="text-center">
            <!-- Title -->
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4">
                {{ $title }}
            </h1>

            <!-- Subtitle -->
            @if($subtitle)
            <p class="text-base sm:text-lg text-blue-100 max-w-2xl mx-auto leading-relaxed">
                {{ $subtitle }}
            </p>
            @endif

            <!-- Decorative Line -->
            <div class="flex items-center justify-center mt-8 space-x-2">
                <div class="w-12 h-0.5 bg-white/30 rounded-full"></div>
                <div class="w-2 h-2 bg-white rounded-full"></div>
                <div class="w-12 h-0.5 bg-white/30 rounded-full"></div>
            </div>
        </div>
    </div>

    <!-- Bottom Wave -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg class="w-full h-12 sm:h-16 text-white" viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,58.7C960,64,1056,64,1152,58.7C1248,53,1344,43,1392,37.3L1440,32L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z" fill="currentColor"/>
        </svg>
    </div>
</section>
