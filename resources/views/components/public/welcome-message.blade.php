@props(['welcomeMessage'])

@if($welcomeMessage)
<!-- Welcome Message Section -->
<section class="py-16 md:py-24 bg-gradient-to-b from-blue-50 to-white relative">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="grid md:grid-cols-12 gap-0">
                <!-- Left Side - Photo & Info -->
                <div class="md:col-span-4 bg-gradient-to-br from-blue-600 to-blue-700 p-8 md:p-10 flex flex-col items-center justify-center text-white">
                    @if($welcomeMessage->photo)
                        <!-- Photo -->
                        <div class="mb-6">
                            <img src="{{ asset('storage/' . $welcomeMessage->photo) }}"
                                 alt="Foto {{ $welcomeMessage->name }}"
                                 class="w-32 h-32 md:w-40 md:h-40 rounded-full object-cover border-4 border-white/30 shadow-xl">
                        </div>
                    @else
                        <!-- Default Icon if no photo -->
                        <div class="mb-6">
                            <div class="w-32 h-32 md:w-40 md:h-40 rounded-full bg-white/20 flex items-center justify-center border-4 border-white/30">
                                <svg class="w-20 h-20 md:w-24 md:h-24 text-white/60" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                        </div>
                    @endif

                    <!-- Name and Position -->
                    <div class="text-center">
                        <h3 class="font-bold text-xl md:text-2xl mb-2">{{ $welcomeMessage->name }}</h3>
                        <p class="text-blue-100 text-sm md:text-base font-medium">{{ $welcomeMessage->position }}</p>
                    </div>

                    @if($welcomeMessage->signature)
                        <!-- Signature -->
                        <div class="mt-6 w-full max-w-[160px]">
                            <img src="{{ asset('storage/' . $welcomeMessage->signature) }}"
                                 alt="Tanda Tangan {{ $welcomeMessage->name }}"
                                 class="w-full h-auto object-contain filter brightness-0 invert opacity-80">
                        </div>
                    @endif
                </div>

                <!-- Right Side - Message -->
                <div class="md:col-span-8 p-8 md:p-12 flex flex-col justify-center">
                    <!-- Quote Icon -->
                    <svg class="w-12 h-12 text-blue-200 mb-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                    </svg>

                    <!-- Welcome Title -->
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">Kata Sambutan</h2>

                    <!-- Message Text -->
                    <div class="prose prose-lg max-w-none">
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line text-base md:text-lg">{{ $welcomeMessage->message }}</p>
                    </div>

                    <!-- Decorative Line -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">Melayani dengan sepenuh hati untuk masyarakat Kabupaten Katingan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
