@extends('layouts.admin.app')

@section('title', 'Detail Struktur Organisasi')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Detail Struktur Organisasi
            </h2>
            <p class="text-sm text-gray-600 mt-1">Informasi lengkap {{ $structure->name }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.structures.edit', $structure) }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg inline-flex items-center transition duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.structures.index') }}"
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg inline-flex items-center transition duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="xl:col-span-2">
                    <!-- Photo Section -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <div class="flex items-center space-x-6">
                                <!-- Photo -->
                                <div class="flex-shrink-0">
                                    <img src="{{ $structure->photo_url }}"
                                         alt="{{ $structure->name }}"
                                         class="w-32 h-32 rounded-lg object-cover border-4 border-gray-200 shadow-sm">
                                </div>

                                <!-- Basic Info -->
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-2xl font-bold text-gray-900">{{ $structure->name }}</h3>
                                        <div class="flex items-center space-x-3">
                                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                                {{ $structure->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $structure->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                            <div class="flex items-center justify-center w-12 h-12 bg-blue-100 text-blue-800 rounded-full text-lg font-bold">
                                                #{{ $structure->order }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <div>
                                            <span class="text-lg font-semibold text-blue-600">{{ $structure->position }}</span>
                                        </div>
                                        <div>
                                            <span class="text-sm text-gray-600">NIP: </span>
                                            <span class="text-sm font-mono text-gray-900">{{ $structure->nip }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detailed Information -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-6">Informasi Detail</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-1">Nama Lengkap</label>
                                        <div class="text-lg font-semibold text-gray-900">{{ $structure->name }}</div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-1">NIP</label>
                                        <div class="text-sm text-gray-900 font-mono bg-gray-50 rounded-md px-3 py-2">{{ $structure->nip }}</div>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-1">Jabatan</label>
                                        <div class="text-lg font-semibold text-gray-900">{{ $structure->position }}</div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-1">Urutan</label>
                                        <div class="text-sm text-gray-900">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Posisi {{ $structure->order }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline/History -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-6">Riwayat</h3>
                            <div class="flow-root">
                                <ul class="space-y-6">
                                    <li>
                                        <div class="relative">
                                            <span class="absolute top-5 left-5 -ml-px h-6 w-0.5 bg-gray-200" aria-hidden="true"></span>
                                            <div class="relative flex items-start space-x-4">
                                                <div class="flex-shrink-0">
                                                    <span class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center ring-4 ring-white shadow">
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                                        <div class="flex-1">
                                                            <p class="text-sm font-medium text-gray-900">Terakhir diupdate</p>
                                                            <p class="text-xs text-gray-500 mt-0.5">Perubahan data struktur organisasi</p>
                                                        </div>
                                                        <div class="mt-2 sm:mt-0 sm:ml-4 flex-shrink-0">
                                                            <time datetime="{{ $structure->updated_at->toISOString() }}"
                                                                  class="text-sm text-gray-500 whitespace-nowrap">
                                                                {{ $structure->updated_at->format('d M Y, H:i') }}
                                                            </time>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="relative">
                                            <div class="relative flex items-start space-x-4">
                                                <div class="flex-shrink-0">
                                                    <span class="h-10 w-10 rounded-full bg-green-500 flex items-center justify-center ring-4 ring-white shadow">
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                                        <div class="flex-1">
                                                            <p class="text-sm font-medium text-gray-900">Struktur dibuat</p>
                                                            <p class="text-xs text-gray-500 mt-0.5">Data struktur organisasi ditambahkan ke sistem</p>
                                                        </div>
                                                        <div class="mt-2 sm:mt-0 sm:ml-4 flex-shrink-0">
                                                            <time datetime="{{ $structure->created_at->toISOString() }}"
                                                                  class="text-sm text-gray-500 whitespace-nowrap">
                                                                {{ $structure->created_at->format('d M Y, H:i') }}
                                                            </time>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="xl:col-span-1">
                    <!-- Quick Actions -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h3>
                            <div class="space-y-3">
                                <a href="{{ route('admin.structures.edit', $structure) }}"
                                   class="w-full bg-blue-50 hover:bg-blue-100 text-blue-700 font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit Struktur
                                </a>

                                <form action="{{ route('admin.structures.destroy', $structure) }}"
                                      method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus struktur ini? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-full bg-red-50 hover:bg-red-100 text-red-700 font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Hapus Struktur
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Structure Information -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Detail</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-600">ID:</span>
                                    <span class="text-sm text-gray-900">{{ $structure->id }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-600">Status:</span>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $structure->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $structure->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-600">Dibuat:</span>
                                    <span class="text-sm text-gray-900">{{ $structure->created_at->format('d/m/Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-600">Diupdate:</span>
                                    <span class="text-sm text-gray-900">{{ $structure->updated_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Related Information -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Terkait</h3>
                            <div class="space-y-4">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <div class="flex">
                                        <svg class="w-5 h-5 text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-medium text-blue-900">Posisi Hierarki</h4>
                                            <p class="text-sm text-blue-700 mt-1">
                                                Struktur ini berada pada urutan ke-{{ $structure->order }} dalam hierarki organisasi.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <div class="flex">
                                        <svg class="w-5 h-5 text-green-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-medium text-green-900">Status Publik</h4>
                                            <p class="text-sm text-green-700 mt-1">
                                                {{ $structure->is_active ? 'Struktur ini akan ditampilkan di website publik.' : 'Struktur ini tidak akan ditampilkan di website publik.' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
