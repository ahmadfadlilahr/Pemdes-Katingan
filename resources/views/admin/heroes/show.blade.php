@extends('layouts.admin.app')

@section('title', 'Detail Hero/Slider')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Detail Hero/Slider
        </h2>
        <div class="flex space-x-2">
            <a href="{{ route('admin.heroes.edit', $hero) }}"
               class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.heroes.index') }}"
               class="inline-flex items-center justify-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="xl:col-span-2 space-y-6">
            <!-- Hero Preview -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Preview Hero</h3>

                    <!-- Hero Container -->
                    <div class="relative bg-gray-900 rounded-lg overflow-hidden" style="min-height: 400px; max-height: 400px;">
                        <!-- Background Image -->
                        @if($hero->image)
                            <img src="{{ $hero->image_url }}"
                                 alt="{{ $hero->title }}"
                                 class="absolute inset-0 w-full h-full object-cover object-center">
                            <!-- Gradient Overlay untuk readability yang lebih baik -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        @endif

                        <!-- Content Overlay - Positioned at bottom -->
                        <div class="absolute inset-x-0 bottom-0 z-10 p-6">
                            <div class="text-center text-white">
                                @if($hero->show_title && $hero->title)
                                    <h1 class="text-xl md:text-2xl font-bold mb-3 leading-tight drop-shadow-lg">{{ $hero->title }}</h1>
                                @endif

                                @if($hero->description)
                                    <p class="text-sm md:text-base mb-4 leading-relaxed opacity-90 max-w-2xl mx-auto drop-shadow-md">{{ $hero->description }}</p>
                                @endif

                                <!-- Buttons -->
                                @if($hero->hasButton1() || $hero->hasButton2())
                                    <div class="flex flex-col sm:flex-row gap-2 justify-center items-center">
                                        @if($hero->hasButton1())
                                            <a href="{{ $hero->button1_url }}"
                                               class="{{ $hero->getButton1Classes() }} inline-flex items-center px-4 py-2 text-xs font-semibold rounded-md transition-all duration-200 shadow-md">
                                                {{ $hero->button1_text }}
                                            </a>
                                        @endif

                                        @if($hero->hasButton2())
                                            <a href="{{ $hero->button2_url }}"
                                               class="{{ $hero->getButton2Classes() }} inline-flex items-center px-4 py-2 text-xs font-semibold rounded-md transition-all duration-200 shadow-md">
                                                {{ $hero->button2_text }}
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hero Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Konten</h3>

                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Judul</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $hero->title }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                @if($hero->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        Tidak Aktif
                                    </span>
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tampilkan Judul</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $hero->show_title ? 'Ya' : 'Tidak' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Posisi Urutan</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $hero->order_position ?? '-' }}</dd>
                        </div>

                        @if($hero->description)
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $hero->description }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Button Details -->
            @if($hero->hasButton1() || $hero->hasButton2())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Tombol</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Button 1 -->
                            @if($hero->hasButton1())
                                <div class="border rounded-lg p-4">
                                    <h4 class="font-medium text-gray-900 mb-3">Tombol 1</h4>
                                    <dl class="space-y-2">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Teks</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $hero->button1_text }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">URL</dt>
                                            <dd class="mt-1">
                                                <a href="{{ $hero->button1_url }}"
                                                   target="_blank"
                                                   class="text-sm text-blue-600 hover:text-blue-500 break-all">
                                                    {{ $hero->button1_url }}
                                                    <svg class="inline w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                    </svg>
                                                </a>
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Style</dt>
                                            <dd class="mt-1">
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $hero->button1_style === 'primary' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                                    {{ ucfirst($hero->button1_style) }}
                                                </span>
                                            </dd>
                                        </div>
                                    </dl>
                                </div>
                            @endif

                            <!-- Button 2 -->
                            @if($hero->hasButton2())
                                <div class="border rounded-lg p-4">
                                    <h4 class="font-medium text-gray-900 mb-3">Tombol 2</h4>
                                    <dl class="space-y-2">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Teks</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $hero->button2_text }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">URL</dt>
                                            <dd class="mt-1">
                                                <a href="{{ $hero->button2_url }}"
                                                   target="_blank"
                                                   class="text-sm text-blue-600 hover:text-blue-500 break-all">
                                                    {{ $hero->button2_url }}
                                                    <svg class="inline w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                    </svg>
                                                </a>
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Style</dt>
                                            <dd class="mt-1">
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $hero->button2_style === 'primary' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                                    {{ ucfirst($hero->button2_style) }}
                                                </span>
                                            </dd>
                                        </div>
                                    </dl>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h3>

                    <div class="space-y-3">
                        <!-- Toggle Status -->
                        <form action="{{ route('admin.heroes.toggle-status', $hero) }}" method="POST" class="w-full">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white {{ $hero->is_active ? 'bg-red-600 hover:bg-red-700 focus:ring-red-500' : 'bg-green-600 hover:bg-green-700 focus:ring-green-500' }} focus:outline-none focus:ring-2 focus:ring-offset-2 transition duration-150 ease-in-out">
                                @if($hero->is_active)
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                    </svg>
                                    Nonaktifkan
                                @else
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Aktifkan
                                @endif
                            </button>
                        </form>

                        <!-- Edit Button -->
                        <a href="{{ route('admin.heroes.edit', $hero) }}"
                           class="w-full flex justify-center py-2 px-4 border border-blue-300 rounded-md shadow-sm text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Hero
                        </a>

                        <!-- Delete Button -->
                        <form action="{{ route('admin.heroes.destroy', $hero) }}" method="POST"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus hero ini? Tindakan ini tidak dapat dibatalkan.')"
                              class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full flex justify-center py-2 px-4 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus Hero
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Meta Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Meta</h3>

                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">ID</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $hero->id }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Dibuat oleh</dt>
                            <dd class="mt-1 flex items-center space-x-2">
                                <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center">
                                    <span class="text-xs font-medium text-white">
                                        {{ substr($hero->user->name ?? 'U', 0, 1) }}
                                    </span>
                                </div>
                                <span class="text-sm text-gray-900">{{ $hero->user->name ?? 'Unknown' }}</span>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Dibuat pada</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $hero->created_at->format('d M Y, H:i') }}
                                <span class="text-gray-500">({{ $hero->created_at->diffForHumans() }})</span>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Terakhir diperbarui</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $hero->updated_at->format('d M Y, H:i') }}
                                <span class="text-gray-500">({{ $hero->updated_at->diffForHumans() }})</span>
                            </dd>
                        </div>

                        @if($hero->image)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">File Gambar</dt>
                                <dd class="mt-1 text-sm text-gray-900 break-all">{{ basename($hero->image) }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
