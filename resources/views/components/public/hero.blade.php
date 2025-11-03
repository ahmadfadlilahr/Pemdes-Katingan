<!-- Hero Section with Slider -->
<section class="relative overflow-hidden">
    @if($heroes && $heroes->count() > 0)
        <!-- Hero Slider -->
        <div class="hero-slider relative" x-data="{ currentSlide: 0, totalSlides: {{ $heroes->count() }} }">
            <!-- Slides Container -->
            <div class="relative">
                @foreach($heroes as $index => $hero)
                <div class="hero-slide transition-opacity duration-700"
                     :class="{ 'opacity-100 z-10': currentSlide === {{ $index }}, 'opacity-0 z-0 absolute inset-0': currentSlide !== {{ $index }} }">

                    <!-- Background Image -->
                    <div class="relative max-h-[500px] sm:max-h-[600px] lg:max-h-[700px] overflow-hidden">
                        @if($hero->image)
                        <img src="{{ Storage::url($hero->image) }}"
                             alt="{{ $hero->title }}"
                             class="w-full h-auto">
                        @else
                        <div class="w-full h-[500px] bg-gradient-to-br from-blue-500 to-indigo-600"></div>
                        @endif
                        <!-- Overlay - Lebih gelap untuk kontras text -->
                        <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/40 to-black/60"></div>
                    </div>

                    <!-- Content -->
                    <div class="absolute inset-0 z-10 flex items-end justify-center pb-12 sm:pb-16 lg:pb-20">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                            <div class="text-center max-w-4xl mx-auto space-y-4 sm:space-y-5">
                                @if($hero->show_title && $hero->title)
                                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight drop-shadow-2xl">
                                    {{ $hero->title }}
                                </h1>
                                @endif

                                @if($hero->description)
                                <p class="text-base sm:text-lg lg:text-xl text-white leading-relaxed drop-shadow-xl">
                                    {{ $hero->description }}
                                </p>
                                @endif

                                @if($hero->button1_text || $hero->button2_text)
                                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center items-center pt-2">
                                    @if($hero->button1_text && $hero->button1_url)
                                    <a href="{{ $hero->button1_url }}"
                                       class="inline-flex items-center justify-center px-6 sm:px-8 py-2.5 sm:py-3 {{ $hero->button1_style === 'outline' ? 'border-2 border-white bg-transparent text-white hover:bg-white hover:text-gray-900' : 'bg-blue-600 text-white hover:bg-blue-700' }} font-semibold text-sm sm:text-base rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                        {{ $hero->button1_text }}
                                    </a>
                                    @endif

                                    @if($hero->button2_text && $hero->button2_url)
                                    <a href="{{ $hero->button2_url }}"
                                       class="inline-flex items-center justify-center px-6 sm:px-8 py-2.5 sm:py-3 {{ $hero->button2_style === 'outline' ? 'border-2 border-white bg-transparent text-white hover:bg-white hover:text-gray-900' : 'bg-blue-600 text-white hover:bg-blue-700' }} font-semibold text-sm sm:text-base rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                        {{ $hero->button2_text }}
                                    </a>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Slider Controls -->
            @if($heroes->count() > 1)
            <div class="absolute bottom-6 sm:bottom-8 left-0 right-0 z-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-center gap-6 lg:gap-8">
                        <!-- Previous Button -->
                        <button @click="currentSlide = currentSlide > 0 ? currentSlide - 1 : totalSlides - 1"
                                class="p-2 sm:p-3 bg-white/80 hover:bg-white text-gray-800 rounded-full shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-200">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>

                        <!-- Navigation Dots -->
                        <div class="flex space-x-2 sm:space-x-3">
                            @foreach($heroes as $index => $hero)
                            <button @click="currentSlide = {{ $index }}"
                                    :class="{ 'bg-white w-8 sm:w-12': currentSlide === {{ $index }}, 'bg-white/50 w-2 sm:w-3': currentSlide !== {{ $index }} }"
                                    class="h-2 sm:h-3 rounded-full transition-all duration-300 hover:bg-white/80"
                                    aria-label="Slide {{ $index + 1 }}">
                            </button>
                            @endforeach
                        </div>

                        <!-- Next Button -->
                        <button @click="currentSlide = currentSlide < totalSlides - 1 ? currentSlide + 1 : 0"
                                class="p-2 sm:p-3 bg-white/80 hover:bg-white text-gray-800 rounded-full shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-200">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Auto Play -->
            <script>
                document.addEventListener('alpine:init', () => {
                    let autoPlayInterval = setInterval(() => {
                        const component = Alpine.$data(document.querySelector('.hero-slider'));
                        if (component) {
                            component.currentSlide = (component.currentSlide + 1) % component.totalSlides;
                        }
                    }, 5000); // Change slide every 5 seconds
                });
            </script>
            @endif
        </div>
    @else
        <!-- Default Hero (No Sliders) -->
        <div class="py-16 lg:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <!-- Text Content -->
                    <div class="space-y-6 text-center lg:text-left">
                        <h1 class="text-4xl lg:text-5xl xl:text-6xl font-bold text-gray-900 leading-tight">
                            Dinas Pemberdayaan Masyarakat dan Desa
                            <span class="text-blue-600">Kabupaten Katingan</span>
                        </h1>
                        <p class="text-lg text-gray-600 leading-relaxed">
                            Berkomitmen untuk mewujudkan masyarakat dan desa yang mandiri, sejahtera, dan berkelanjutan melalui program-program pemberdayaan yang inovatif dan partisipatif.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <a href="#layanan" class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                Lihat Layanan
                                <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                            <a href="{{ route('kontak') }}" class="inline-flex items-center justify-center px-6 py-3 border-2 border-blue-600 text-blue-600 font-semibold rounded-lg hover:bg-blue-600 hover:text-white transition-colors duration-200">
                                Hubungi Kami
                            </a>
                        </div>
                    </div>

                    <!-- Image/Visual -->
                    <div class="relative">
                        <div class="relative z-10">
                            <img src="{{ asset('Logo_Dinas_PMD.png') }}" alt="Logo Dinas PMD" class="w-48 h-48 lg:w-64 lg:h-64 mx-auto">
                        </div>
                        <!-- Background decoration -->
                        <div class="absolute inset-0 -z-10 bg-gradient-to-r from-blue-200 to-indigo-200 rounded-full opacity-20 transform scale-150"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>
