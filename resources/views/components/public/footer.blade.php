@php
    // Fetch contact data for footer (cached for performance)
    $footerContact = cache()->remember('footer_contact', 3600, function () {
        return \App\Models\Contact::first();
    });
@endphp

<!-- Footer -->
<footer id="kontak" class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Logo & Description -->
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center space-x-3 mb-4">
                    <img src="{{ asset('Logo_Dinas_PMD.png') }}" alt="Logo PMD" class="h-12 w-12">
                    <div>
                        <div class="text-lg font-bold">Dinas PMD</div>
                        <div class="text-sm text-gray-300">Kabupaten Katingan</div>
                    </div>
                </div>
                <p class="text-gray-300 text-sm leading-relaxed mb-6">
                    Dinas Pemberdayaan Masyarakat dan Desa Kabupaten Katingan berkomitmen untuk mewujudkan masyarakat dan desa yang mandiri, sejahtera, dan berkelanjutan.
                </p>

                <!-- Dynamic Social Media -->
                <x-public.footer-social-media :contact="$footerContact ?? null" />
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Menu Utama</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Beranda</a></li>
                    <li><a href="{{ route('vision-mission') }}" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Visi & Misi</a></li>
                    <li><a href="{{ route('organization-structure') }}" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Struktur Organisasi</a></li>
                    <li><a href="{{ route('news') }}" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Berita</a></li>
                    <li><a href="{{ route('agenda') }}" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Agenda</a></li>
                    <li><a href="{{ route('documents') }}" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Dokumen</a></li>
                    <li><a href="{{ route('gallery') }}" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">Galeri</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <!-- Dynamic Contact Information -->
                <x-public.footer-contact :contact="$footerContact ?? null" />
            </div>
        </div>
    </div>

    <!-- Bottom Footer -->
    <div class="border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="text-sm text-gray-400">
                    &copy; {{ date('Y') }} Dinas PMD Kabupaten Katingan. Hak Cipta Dilindungi.
                </div>
                <div class="flex space-x-6">
                    {{-- <a href="#" class="text-sm text-gray-400 hover:text-white transition-colors duration-200">Kebijakan Privasi</a>
                    <a href="#" class="text-sm text-gray-400 hover:text-white transition-colors duration-200">Syarat & Ketentuan</a>
                    <a href="#" class="text-sm text-gray-400 hover:text-white transition-colors duration-200">Peta Situs</a> --}}
                </div>
            </div>
        </div>
    </div>
</footer>
