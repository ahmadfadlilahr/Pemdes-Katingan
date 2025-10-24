@extends('layouts.admin.app')

@section('title', 'Kelola Hero/Slider')

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    @media (max-width: 640px) {
        .hero-card {
            margin-bottom: 1rem;
        }

        .hero-actions {
            justify-content: space-around;
            width: 100%;
        }
    }

    .hero-card:hover {
        transform: translateY(-1px);
        transition: all 0.2s ease-in-out;
    }

    .status-toggle {
        transition: all 0.2s ease-in-out;
    }
</style>
@endpush

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Kelola Hero/Slider
        </h2>
        <a href="{{ route('admin.heroes.create') }}"
           class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Hero
        </a>
    </div>
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <!-- Filter & Search -->
        <div class="p-6 border-b border-gray-200">
            <form method="GET" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <label for="search" class="sr-only">Cari hero</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text"
                               name="search"
                               id="search"
                               value="{{ request('search') }}"
                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Cari hero...">
                    </div>
                </div>

                <div class="sm:w-48">
                    <label for="status" class="sr-only">Filter status</label>
                    <select name="status"
                            id="status"
                            class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filter
                </button>
            </form>
        </div>

        <!-- Heroes List -->
        <div class="p-6">
            @if($heroes->count() > 0)
                <div class="space-y-4">
                    @foreach($heroes as $hero)
                        <div class="hero-card flex flex-col lg:flex-row bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                            <!-- Image -->
                            <div class="lg:w-64 flex-shrink-0">
                                <img src="{{ $hero->image_url }}"
                                     alt="{{ $hero->title }}"
                                     class="w-full h-48 lg:h-40 object-cover rounded-t-lg lg:rounded-l-lg lg:rounded-t-none">
                            </div>

                            <!-- Content -->
                            <div class="flex-1 p-4 lg:p-6">
                                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between space-y-4 lg:space-y-0">
                                    <div class="flex-1 min-w-0 lg:pr-4">
                                        <!-- Title -->
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2 leading-tight">
                                            <a href="{{ route('admin.heroes.show', $hero) }}" class="hover:text-blue-600 line-clamp-2" title="{{ $hero->title }}">
                                                {{ Str::limit($hero->title, 60) }}
                                            </a>
                                        </h3>

                                        <!-- Meta -->
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-1 sm:space-y-0 text-sm text-gray-500 mb-3">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                <span class="truncate">{{ $hero->user->name }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 110 2h-1v12a2 2 0 01-2 2H5a2 2 0 01-2-2V6H2a1 1 0 110-2h4z"></path>
                                                </svg>
                                                <span class="whitespace-nowrap">Posisi: {{ $hero->order_position }}</span>
                                            </div>
                                        </div>

                                        <!-- Status & Show Title -->
                                        <div class="flex flex-wrap gap-2 mb-3">
                                            @if($hero->is_active)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Tidak Aktif
                                                </span>
                                            @endif

                                            @if($hero->show_title)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Tampil Judul
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Description -->
                                        @if($hero->description)
                                            <p class="text-gray-600 text-sm line-clamp-2 mb-3">
                                                {{ Str::limit($hero->description, 120) }}
                                            </p>
                                        @endif

                                        <!-- Buttons Info -->
                                        @if($hero->hasButton1() || $hero->hasButton2())
                                            <div class="flex flex-wrap gap-1 text-xs text-gray-500">
                                                @if($hero->hasButton1())
                                                    <span class="bg-gray-100 px-2 py-1 rounded">{{ $hero->button1_text }}</span>
                                                @endif
                                                @if($hero->hasButton2())
                                                    <span class="bg-gray-100 px-2 py-1 rounded">{{ $hero->button2_text }}</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Actions -->
                                    <div class="hero-actions flex-shrink-0 flex items-center space-x-2 lg:space-x-1">
                                        <a href="{{ route('admin.heroes.show', $hero) }}"
                                           class="inline-flex items-center px-2.5 py-1.5 lg:px-2 lg:py-1 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                           title="Lihat Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <span class="ml-1 sm:hidden text-sm">Lihat</span>
                                        </a>

                                        <a href="{{ route('admin.heroes.edit', $hero) }}"
                                           class="inline-flex items-center px-2.5 py-1.5 lg:px-2 lg:py-1 text-indigo-600 hover:text-indigo-900 hover:bg-indigo-50 rounded-lg transition-colors duration-200"
                                           title="Edit Hero">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            <span class="ml-1 sm:hidden text-sm">Edit</span>
                                        </a>

                                        <form method="POST" action="{{ route('admin.heroes.toggle-status', $hero) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="status-toggle inline-flex items-center px-2.5 py-1.5 lg:px-2 lg:py-1 {{ $hero->is_active ? 'text-red-600 hover:text-red-900 hover:bg-red-50' : 'text-green-600 hover:text-green-900 hover:bg-green-50' }} rounded-lg transition-colors duration-200"
                                                    title="{{ $hero->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                @if($hero->is_active)
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                @endif
                                                <span class="ml-1 sm:hidden text-sm">{{ $hero->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</span>
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.heroes.destroy', $hero) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus hero ini?')"
                                                    class="inline-flex items-center px-2.5 py-1.5 lg:px-2 lg:py-1 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-colors duration-200"
                                                    title="Hapus Hero">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                <span class="ml-1 sm:hidden text-sm">Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $heroes->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada hero</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat hero/slider pertama Anda.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.heroes.create') }}"
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Hero
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
