<x-public-layout title="Agenda Kegiatan - Dinas PMD Kabupaten Katingan" description="Jadwal dan agenda kegiatan Dinas Pemberdayaan Masyarakat dan Desa Kabupaten Katingan">


    @include('components.public.page-header', [
        'title' => 'Agenda Kegiatan',
        'subtitle' => 'Jadwal dan kegiatan yang akan datang dari Dinas PMD Kabupaten Katingan',
        'breadcrumbs' => [
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Agenda', 'url' => null]
        ]
    ])


    <section class="py-12 sm:py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10">


                <div class="lg:col-span-2">

                    @if($agendas && $agendas->count() > 0)

                        <div class="space-y-6">
                            @foreach($agendas as $agenda)
                                @include('components.public.agenda-card', ['agenda' => $agenda])
                            @endforeach
                        </div>


                        <div class="mt-8">
                            {{ $agendas->links() }}
                        </div>
                    @else

                        @include('components.public.empty-state', [
                            'icon' => 'calendar',
                            'title' => 'Belum Ada Agenda',
                            'message' => 'Agenda dan jadwal kegiatan akan segera hadir di sini.'
                        ])
                    @endif

                </div>


                <aside class="lg:col-span-1">
                    <div class="sticky top-4 space-y-6">


                        @include('components.public.agenda-search')

                        
                        @include('components.public.agenda-sidebar', ['upcomingAgenda' => $upcomingAgenda])

                    </div>
                </aside>

            </div>

        </div>
    </section>

</x-public-layout>
