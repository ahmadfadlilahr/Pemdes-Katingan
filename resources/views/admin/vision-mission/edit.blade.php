@extends('layouts.admin.app')

@section('title', 'Edit Visi & Misi')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Edit Visi & Misi
            </h2>
            <p class="text-sm text-gray-600 mt-1">Perbarui visi dan misi organisasi</p>
        </div>
        <a href="{{ route('admin.vision-mission.index') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('admin.vision-mission.update', $visionMission) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="xl:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <!-- Vision Field -->
                            <div class="mb-6">
                                <label for="vision" class="block text-sm font-medium text-gray-700 mb-2">
                                    Visi <span class="text-red-500">*</span>
                                </label>
                                <textarea
                                    id="vision"
                                    name="vision"
                                    rows="6"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('vision') @enderror"
                                    placeholder="Masukkan visi organisasi..."
                                    required>{{ old('vision', $visionMission->vision) }}</textarea>
                                @error('vision')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500">
                                    Visi adalah gambaran masa depan organisasi yang ingin dicapai
                                </p>
                            </div>

                            <!-- Mission Field -->
                            <div class="mb-6">
                                <label for="mission" class="block text-sm font-medium text-gray-700 mb-2">
                                    Misi <span class="text-red-500">*</span>
                                </label>
                                <textarea
                                    id="mission"
                                    name="mission"
                                    rows="10"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('mission') @enderror"
                                    placeholder="Masukkan misi organisasi..."
                                    required>{{ old('mission', $visionMission->mission) }}</textarea>
                                @error('mission')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500">
                                    Misi adalah langkah-langkah strategis untuk mencapai visi
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="xl:col-span-1 space-y-6">
                    <!-- Status Section -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Status Publikasi</h3>

                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input
                                            id="is_active"
                                            name="is_active"
                                            type="checkbox"
                                            value="1"
                                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                            {{ old('is_active', $visionMission->is_active) ? 'checked' : '' }}>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="is_active" class="font-medium text-gray-700">
                                            Aktifkan Visi & Misi Ini
                                        </label>
                                        <p class="text-gray-500">
                                            Jika diaktifkan, visi & misi ini akan ditampilkan di website
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            Hanya satu visi & misi yang dapat aktif pada satu waktu. Jika Anda mengaktifkan ini, visi & misi lain akan dinonaktifkan otomatis.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Metadata Section -->
                    <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi</h3>

                            <div class="space-y-3 text-sm">
                                <div>
                                    <span class="text-gray-500">Dibuat oleh:</span>
                                    <p class="font-medium text-gray-900">{{ $visionMission->user->name }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Dibuat pada:</span>
                                    <p class="font-medium text-gray-900">{{ $visionMission->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Terakhir diubah:</span>
                                    <p class="font-medium text-gray-900">{{ $visionMission->updated_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Status saat ini:</span>
                                    <p class="mt-1">
                                        @if($visionMission->is_active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 space-y-3">
                            <button type="submit"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Update Visi & Misi
                            </button>

                            <a href="{{ route('admin.vision-mission.index') }}"
                               class="w-full inline-flex justify-center items-center px-4 py-2 bg-white hover:bg-gray-50 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest transition ease-in-out duration-150">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Batal
                            </a>
                        </div>
                    </div>

                    <!-- Info Panel -->
                    <div class="bg-blue-50 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Tips</h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            <li>Visi harus jelas dan mudah dipahami</li>
                                            <li>Misi harus spesifik dan terukur</li>
                                            <li>Gunakan bahasa yang formal dan profesional</li>
                                            <li>Pastikan sesuai dengan karakteristik organisasi</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
