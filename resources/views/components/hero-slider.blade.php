@if($heroes->count() > 0)
    <div class="relative overflow-hidden bg-gray                     <button type="button"
                    class="hero-next absolute right-4 top-1/2 transform -translate-y-1/2 z-30 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white p-3 rounded-full transition-all duration-200 hover:scale-110" <button type="button"
                    class="hero-prev absolute left-4 top-1/2 transform -translate-y-1/2 z-30 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white p-3 rounded-full transition-all duration-200 hover:scale-110"00" id="heroSlider">
        <!-- Hero Slides -->
        <div class="hero-slides">
            @foreach($heroes as $index => $hero)
                <div class="hero-slide {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}">
                    <!-- Background Image -->
                    @if($hero->image)
                        <img src="{{ $hero->image_url }}"
                             alt="{{ $hero->title }}"
                             class="absolute inset-0 w-full h-full object-cover">
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    @else
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    @endif

                    <!-- Content -->
                    <div class="relative z-10 container mx-auto px-4 h-full flex items-end justify-center">
                        <div class="text-center text-white max-w-4xl pb-12 pt-8">
                            @if($hero->show_title && $hero->title)
                                <h1 class="text-2xl md:text-4xl lg:text-5xl font-bold mb-4 leading-tight drop-shadow-lg animate-fade-in-up">
                                    {{ $hero->title }}
                                </h1>
                            @endif

                            @if($hero->description)
                                <p class="text-base md:text-lg lg:text-xl mb-8 leading-relaxed opacity-90 max-w-3xl mx-auto drop-shadow-md animate-fade-in-up animation-delay-200">
                                    {{ $hero->description }}
                                </p>
                            @endif

                            <!-- Buttons -->
                            @if($hero->hasButton1() || $hero->hasButton2())
                                <div class="flex flex-col sm:flex-row gap-3 justify-center items-center animate-fade-in-up animation-delay-400">
                                    @if($hero->hasButton1())
                                        <a href="{{ $hero->button1_url }}"
                                           class="{{ $hero->getButton1Classes() }} inline-flex items-center px-8 py-3 text-sm font-semibold rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                            {{ $hero->button1_text }}
                                        </a>
                                    @endif

                                    @if($hero->hasButton2())
                                        <a href="{{ $hero->button2_url }}"
                                           class="{{ $hero->getButton2Classes() }} inline-flex items-center px-8 py-3 text-sm font-semibold rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                            {{ $hero->button2_text }}
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Navigation Dots -->
        @if($heroes->count() > 1)
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 z-30">
                <div class="flex space-x-2">
                    @foreach($heroes as $index => $hero)
                        <button type="button"
                                class="hero-dot w-3 h-3 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-white' : 'bg-white/50 hover:bg-white/75' }}"
                                data-slide="{{ $index }}"
                                aria-label="Go to slide {{ $index + 1 }}">
                        </button>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Navigation Arrows -->
        @if($heroes->count() > 1)
            <button type="button"
                    class="hero-prev absolute left-4 top-1/2 transform -translate-y-1/2 z-20 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white p-3 rounded-full transition-all duration-200 hover:scale-110"
                    aria-label="Previous slide">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <button type="button"
                    class="hero-next absolute right-4 top-1/2 transform -translate-y-1/2 z-20 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white p-3 rounded-full transition-all duration-200 hover:scale-110"
                    aria-label="Next slide">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        @endif
    </div>

    @push('styles')
    <style>
        #heroSlider {
            min-height: 60vh;
        }

        @media (min-width: 768px) {
            #heroSlider {
                min-height: 70vh;
            }
        }

        @media (min-width: 1024px) {
            #heroSlider {
                min-height: 80vh;
            }
        }

        .hero-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .hero-slide.active {
            opacity: 1;
        }

        /* Animation Classes */
        .animate-fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animation-delay-200 {
            animation-delay: 0.2s;
        }

        .animation-delay-400 {
            animation-delay: 0.4s;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Reset animations when slide changes */
        .hero-slide:not(.active) .animate-fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            animation: none;
        }

        .hero-slide.active .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const heroSlider = document.getElementById('heroSlider');
            if (!heroSlider) return;

            const slides = heroSlider.querySelectorAll('.hero-slide');
            const dots = heroSlider.querySelectorAll('.hero-dot');
            const prevBtn = heroSlider.querySelector('.hero-prev');
            const nextBtn = heroSlider.querySelector('.hero-next');

            let currentSlide = 0;
            const totalSlides = slides.length;

            if (totalSlides <= 1) return;

            // Function to show specific slide
            function showSlide(index) {
                // Hide all slides
                slides.forEach(slide => slide.classList.remove('active'));
                dots.forEach(dot => dot.classList.remove('bg-white'));
                dots.forEach(dot => dot.classList.add('bg-white/50'));

                // Show current slide
                slides[index].classList.add('active');
                if (dots[index]) {
                    dots[index].classList.add('bg-white');
                    dots[index].classList.remove('bg-white/50');
                }

                currentSlide = index;
            }

            // Next slide function
            function nextSlide() {
                const next = (currentSlide + 1) % totalSlides;
                showSlide(next);
            }

            // Previous slide function
            function prevSlide() {
                const prev = (currentSlide - 1 + totalSlides) % totalSlides;
                showSlide(prev);
            }

            // Event listeners
            if (nextBtn) {
                nextBtn.addEventListener('click', nextSlide);
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', prevSlide);
            }

            // Dot navigation
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => showSlide(index));
            });

            // Auto-play slider
            let autoPlayInterval = setInterval(nextSlide, 5000);

            // Pause auto-play on hover
            heroSlider.addEventListener('mouseenter', () => {
                clearInterval(autoPlayInterval);
            });

            // Resume auto-play when mouse leaves
            heroSlider.addEventListener('mouseleave', () => {
                autoPlayInterval = setInterval(nextSlide, 5000);
            });

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') {
                    prevSlide();
                } else if (e.key === 'ArrowRight') {
                    nextSlide();
                }
            });

            // Touch/swipe support
            let startX = 0;
            let endX = 0;

            heroSlider.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
            });

            heroSlider.addEventListener('touchend', (e) => {
                endX = e.changedTouches[0].clientX;
                const diff = startX - endX;

                // Swipe threshold
                if (Math.abs(diff) > 50) {
                    if (diff > 0) {
                        nextSlide(); // Swipe left - next slide
                    } else {
                        prevSlide(); // Swipe right - previous slide
                    }
                }
            });
        });
    </script>
    @endpush
@endif
