@extends('layouts.admin.app')

@section('title', 'Edit Struktur Organisasi')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Edit Struktur Organisasi
            </h2>
            <p class="text-sm text-gray-600 mt-1">Edit informasi {{ $structure->name }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.structures.show', $structure) }}"
               class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg inline-flex items-center transition duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Lihat Detail
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
                <!-- Main Form -->
                <div class="xl:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <form action="{{ route('admin.structures.update', $structure) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                                @csrf
                                @method('PUT')

                                <!-- Photo Section -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Foto Pejabat</h3>
                                    <div class="flex items-start space-x-6">
                                        <!-- Photo Preview -->
                                        <div class="flex-shrink-0">
                                            <div class="w-32 h-32 rounded-lg overflow-hidden bg-gray-200 border-2 border-dashed border-gray-300">
                                                <img id="photoPreview"
                                                     src="{{ $structure->photo_url }}"
                                                     alt="Preview"
                                                     class="w-full h-full object-cover">
                                            </div>
                                            @if($structure->photo)
                                                <p class="text-xs text-gray-500 mt-2 text-center">Foto saat ini</p>
                                            @endif
                                        </div>

                                        <!-- Photo Upload -->
                                        <div class="flex-1">
                                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                                                Upload Foto Baru
                                            </label>
                                            <input type="file"
                                                   name="photo"
                                                   id="photo"
                                                   accept="image/jpeg,image/png,image/jpg,image/gif"
                                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('photo') border-red-300 @enderror">
                                            @error('photo')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                            <p class="text-xs text-gray-500 mt-1">
                                                Format: JPEG, PNG, JPG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Basic Information Section -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Name -->
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                                Nama Lengkap <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text"
                                                   name="name"
                                                   id="name"
                                                   value="{{ old('name', $structure->name) }}"
                                                   required
                                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') @enderror"
                                                   placeholder="Masukkan nama lengkap pejabat">
                                            @error('name')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- NIP -->
                                        <div>
                                            <label for="nip" class="block text-sm font-medium text-gray-700 mb-2">
                                                NIP (Nomor Induk Pegawai) <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text"
                                                   name="nip"
                                                   id="nip"
                                                   value="{{ old('nip', $structure->nip) }}"
                                                   required
                                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nip') @enderror"
                                                   placeholder="Contoh: 198501012010011001">
                                            @error('nip')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Position & Order Section -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Jabatan & Urutan</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Position -->
                                        <div>
                                            <label for="position" class="block text-sm font-medium text-gray-700 mb-2">
                                                Jabatan <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text"
                                                   name="position"
                                                   id="position"
                                                   value="{{ old('position', $structure->position) }}"
                                                   required
                                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('position') @enderror"
                                                   placeholder="Contoh: Kepala Dinas, Sekretaris, dll">
                                            @error('position')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Order -->
                                        <div>
                                            <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                                                Urutan <span class="text-red-500">*</span>
                                            </label>
                                            <input type="number"
                                                   name="order"
                                                   id="order"
                                                   value="{{ old('order', $structure->order) }}"
                                                   min="1"
                                                   required
                                                   class="w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('order') border-red-500 @else @enderror">
                                            @error('order')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                            <div class="mt-2 space-y-1">
                                                <p class="text-xs text-gray-600">
                                                    📌 Urutan saat ini: <span class="font-semibold text-blue-600">{{ $structure->order }}</span>
                                                </p>
                                                <p class="text-xs text-green-600 font-medium">
                                                    ✅ Boleh gunakan nomor yang SAMA untuk bersanding sejajar!
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    Ubah ke urutan yang sama dengan pegawai lain untuk ditampilkan horizontal dalam 1 baris.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Section -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Status</h3>
                                    <div class="flex items-center">
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox"
                                               name="is_active"
                                               id="is_active"
                                               value="1"
                                               {{ old('is_active', $structure->is_active) ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <label for="is_active" class="ml-2 text-sm text-gray-700">
                                            Aktif
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Struktur yang aktif akan ditampilkan di website publik
                                    </p>
                                </div>

                                <!-- Submit Buttons -->
                                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                                    <a href="{{ route('admin.structures.index') }}"
                                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                                        Batal
                                    </a>
                                    <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                                        Update Struktur
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Information -->
                <div class="xl:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Struktur</h3>

                            <div class="space-y-4">
                                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                    <span class="text-sm font-medium text-gray-600">Dibuat:</span>
                                    <span class="text-sm text-gray-900">{{ $structure->created_at->format('d M Y H:i') }}</span>
                                </div>
                                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                    <span class="text-sm font-medium text-gray-600">Diupdate:</span>
                                    <span class="text-sm text-gray-900">{{ $structure->updated_at->format('d M Y H:i') }}</span>
                                </div>
                                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                    <span class="text-sm font-medium text-gray-600">Status Saat Ini:</span>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $structure->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $structure->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Panduan</h3>

                            <div class="space-y-4">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <div class="flex">
                                        <svg class="w-5 h-5 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-medium text-blue-900">Sistem Hierarki</h4>
                                            <p class="text-sm text-blue-700 mt-1">
                                                <span class="font-semibold">Urutan yang SAMA</span> = sejajar horizontal.<br>
                                                <span class="font-semibold">Urutan BERBEDA</span> = baris baru di bawahnya.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                                    <div class="flex">
                                        <svg class="w-5 h-5 text-purple-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-medium text-purple-900">Contoh</h4>
                                            <ul class="text-sm text-purple-700 mt-1 space-y-0.5">
                                                <li>• Urutan 1: Kepala Dinas</li>
                                                <li>• Urutan 2: Sekretaris</li>
                                                <li>• Urutan 3: Kabid A, B, C (sejajar)</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <div class="flex">
                                        <svg class="w-5 h-5 text-yellow-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-medium text-yellow-900">NIP Unik</h4>
                                            <p class="text-sm text-yellow-700 mt-1">
                                                NIP harus unik dan tidak boleh sama dengan pejabat lain dalam sistem.
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

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Photo preview functionality
            const photoInput = document.getElementById('photo');
            const photoPreview = document.getElementById('photoPreview');

            if (photoInput && photoPreview) {
                photoInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            photoPreview.src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Auto format NIP input
            const nipInput = document.getElementById('nip');
            if (nipInput) {
                nipInput.addEventListener('input', function(e) {
                    // Remove any non-numeric characters
                    let value = e.target.value.replace(/\D/g, '');

                    // Limit to 18 digits (standard NIP length)
                    if (value.length > 18) {
                        value = value.substring(0, 18);
                    }

                    e.target.value = value;
                });
            }

            // Auto capitalize name and position
            const nameInput = document.getElementById('name');
            const positionInput = document.getElementById('position');

            function capitalizeWords(input) {
                if (input) {
                    input.addEventListener('blur', function(e) {
                        const words = e.target.value.toLowerCase().split(' ');
                        const capitalizedWords = words.map(word => {
                            return word.charAt(0).toUpperCase() + word.slice(1);
                        });
                        e.target.value = capitalizedWords.join(' ');
                    });
                }
            }

            capitalizeWords(nameInput);
            capitalizeWords(positionInput);
        });
    </script>
    @endpush
@endsection
