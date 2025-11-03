@extends('layouts.admin.app')

@section('title', 'Detail Agenda')

@section('header')
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Detail Agenda
            </h2>
            <p class="text-sm text-gray-600 mt-1">{{ $agenda->title }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.agenda.edit', $agenda) }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg inline-flex items-center transition duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>

            <form method="POST" action="{{ route('admin.agenda.toggle-status', $agenda) }}" class="inline">
                @csrf
                @method('PATCH')
                <button type="submit"
                        class="bg-{{ $agenda->is_active ? 'yellow' : 'green' }}-500 hover:bg-{{ $agenda->is_active ? 'yellow' : 'green' }}-700 text-white font-bold py-2 px-4 rounded-lg inline-flex items-center transition duration-200">
                    @if($agenda->is_active)
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L5.636 5.636"></path>
                        </svg>
                        Nonaktifkan
                    @else
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Aktifkan
                    @endif
                </button>
            </form>

            <form method="POST" action="{{ route('admin.agenda.destroy', $agenda) }}"
                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus agenda ini?')"
                  class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg inline-flex items-center transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus
                </button>
            </form>

            <a href="{{ route('admin.agenda.index') }}"
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
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Header Section -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex flex-col md:flex-row md:items-start md:space-x-6">
                        @if($agenda->image)
                            <div class="flex-shrink-0 mb-4 md:mb-0">
                                <img src="{{ $agenda->image_url }}"
                                     alt="{{ $agenda->title }}"
                                     class="w-full md:w-64 h-64 object-cover rounded-lg shadow-md">
                            </div>
                        @endif

                        <div class="flex-1">
                            <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $agenda->title }}</h1>

                            <!-- Status Badges -->
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    @if($agenda->status === 'draft') bg-gray-100 text-gray-800
                                    @elseif($agenda->status === 'scheduled')
                                    @elseif($agenda->status === 'ongoing')
                                    @elseif($agenda->status === 'completed')
                                    @elseif($agenda->status === 'cancelled')
                                    @endif">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <circle cx="10" cy="10" r="3"></circle>
                                    </svg>
                                    {{ $agenda->status_label }}
                                </span>

                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    {{ $agenda->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    @if($agenda->is_active)
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Dipublikasikan
                                    @else
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Tidak Dipublikasikan
                                    @endif
                                </span>
                            </div>

                            <!-- Meta Information -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="font-medium">Tanggal:</span>
                                    <span class="ml-1">{{ $agenda->date_range }}</span>
                                </div>

                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="font-medium">Waktu:</span>
                                    <span class="ml-1">{{ $agenda->duration }}</span>
                                </div>

                                @if($agenda->location)
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="font-medium">Lokasi:</span>
                                    <span class="ml-1">{{ $agenda->location }}</span>
                                </div>
                                @endif

                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="font-medium">Dibuat oleh:</span>
                                    <span class="ml-1">{{ $agenda->user->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Main Content -->
                        <div class="lg:col-span-2">
                            <div class="space-y-6">
                                <!-- Description -->
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi</h3>
                                                                    <div class="prose max-w-none text-gray-700">
                                        {!! nl2br(e($agenda->description)) !!}
                                    </div>
                                </div>

                                <!-- Document Downloads -->
                                @if($agenda->document)
                                <div class="bg-blue-50 rounded-lg p-4">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Dokumen Pendukung</h3>
                                    <a href="{{ $agenda->document_url }}"
                                       target="_blank"
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Download Dokumen
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="space-y-6">
                            <!-- Agenda Status Info -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Informasi Status</h3>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Status Saat Ini:</span>
                                        <span class="font-medium">{{ $agenda->status_label }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Publikasi:</span>
                                        <span class="font-medium {{ $agenda->is_active ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $agenda->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Dibuat:</span>
                                        <span class="font-medium">{{ $agenda->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Diperbarui:</span>
                                        <span class="font-medium">{{ $agenda->updated_at->format('d M Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Update Status -->
                            @if($agenda->status !== 'completed' && $agenda->status !== 'cancelled')
                            <div class="bg-blue-50 rounded-lg p-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Update Status</h3>
                                <form method="POST" action="{{ route('admin.agenda.update-status', $agenda) }}" class="space-y-3">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="draft" {{ $agenda->status === 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="scheduled" {{ $agenda->status === 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                                        <option value="ongoing" {{ $agenda->status === 'ongoing' ? 'selected' : '' }}>Berlangsung</option>
                                        <option value="completed" {{ $agenda->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                                        <option value="cancelled" {{ $agenda->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                    <button type="submit"
                                            class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                                        Update
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
