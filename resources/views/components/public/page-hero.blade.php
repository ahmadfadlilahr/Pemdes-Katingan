<!-- Page Hero Section -->
<section class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 py-16 lg:py-20 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent"></div>
        <svg class="absolute bottom-0 left-0 w-full h-24 text-blue-500 opacity-30" fill="currentColor" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
        </svg>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <!-- Breadcrumb -->
            @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
                <nav class="flex justify-center mb-8" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        @foreach($breadcrumbs as $index => $breadcrumb)
                            <li class="inline-flex items-center">
                                @if($index > 0)
                                    <svg class="w-4 h-4 text-blue-200 mx-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                                @if($breadcrumb['url'])
                                    <a href="{{ $breadcrumb['url'] }}" class="text-blue-200 hover:text-white text-sm font-medium transition duration-200">
                                        {{ $breadcrumb['name'] }}
                                    </a>
                                @else
                                    <span class="text-white text-sm font-medium">{{ $breadcrumb['name'] }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </nav>
            @endif

            <!-- Title -->
            <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4">
                {{ $title }}
            </h1>

            <!-- Subtitle -->
            @if(isset($subtitle))
                <p class="text-xl lg:text-2xl text-blue-100 mb-6 font-medium">
                    {{ $subtitle }}
                </p>
            @endif

            <!-- Description -->
            @if(isset($description))
                <p class="text-lg text-blue-100 max-w-3xl mx-auto leading-relaxed">
                    {{ $description }}
                </p>
            @endif
        </div>
    </div>
</section>
