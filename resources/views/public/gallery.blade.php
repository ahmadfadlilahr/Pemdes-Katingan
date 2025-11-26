<x-public-layout>

    <x-public.page-header
        title="Galeri Foto"
        subtitle="Dokumentasi kegiatan dan momen penting Dinas Pemberdayaan Masyarakat dan Desa Kabupaten Katingan"
    />

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10">


                <div class="lg:col-span-2">

                    <x-public.gallery-search :search="request('search')" />


                    @if($galleries->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                            @foreach($galleries as $gallery)
                                <x-public.gallery-card :gallery="$gallery" />
                            @endforeach
                        </div>


                        @if($galleries->hasPages())
                            <div class="mt-8">
                                {{ $galleries->links() }}
                            </div>
                        @endif
                    @else

                        <x-public.empty-state
                            icon="photo"
                            title="Galeri Tidak Ditemukan"
                            :message="request('search')
                                ? 'Tidak ada galeri yang sesuai dengan pencarian \'' . request('search') . '\''
                                : 'Belum ada galeri yang tersedia saat ini.'"
                        />
                    @endif
                </div>

                
                <aside class="lg:col-span-1">
                    <div class="sticky top-4 space-y-6">
                        <x-public.gallery-sidebar
                            :latestGalleries="$latestGalleries"
                            :totalGalleries="$galleries->total()"
                        />
                    </div>
                </aside>

            </div>
        </div>
    </div>
</x-public-layout>
