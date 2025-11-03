@extends('layouts.admin.app')

@section('title', 'Tambah Struktur Organisasi')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Tambah Struktur Organisasi
            </h2>
            <p class="text-sm text-gray-600 mt-1">Tambahkan pejabat baru ke struktur organisasi</p>
        </div>
        <a href="{{ route('admin.structures.index') }}"
           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg inline-flex items-center transition duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
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
                            <form action="{{ route('admin.structures.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                                @csrf

                                <!-- Photo Section -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Foto Pejabat</h3>
                                    <div class="flex items-start space-x-6">
                                        <!-- Photo Preview -->
                                        <div class="flex-shrink-0">
                                            <div class="w-32 h-32 rounded-lg overflow-hidden bg-gray-200 border-2 border-dashed border-gray-300">
                                                <img id="photoPreview"
                                                     src="{{ asset('images/default-avatar.svg') }}"
                                                     alt="Preview"
                                                     class="w-full h-full object-cover">
                                            </div>
                                        </div>

                                        <!-- Photo Upload -->
                                        <div class="flex-1">
                                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                                                Upload Foto
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
                                                Format: JPEG, PNG, JPG, GIF. Maksimal 2MB.
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
                                                   value="{{ old('name') }}"
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
                                                   value="{{ old('nip') }}"
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
                                                   value="{{ old('position') }}"
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
                                                   value="{{ old('order', $nextOrder) }}"
                                                   min="1"
                                                   required
                                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('order') @enderror">
                                            @error('order')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                            <p class="text-xs text-gray-500 mt-1">
                                                Angka terkecil akan tampil paling atas. Urutan selanjutnya yang tersedia: {{ $nextOrder }}
                                            </p>
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
                                               {{ old('is_active', true) ? 'checked' : '' }}
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
                                        Simpan Struktur
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Information -->
                <div class="xl:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi</h3>

                            <div class="space-y-4">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <div class="flex">
                                        <svg class="w-5 h-5 text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-medium text-blue-900">Urutan Struktur</h4>
                                            <p class="text-sm text-blue-700 mt-1">
                                                Angka urutan menentukan posisi tampil di struktur organisasi. Semakin kecil angka, semakin atas posisinya.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <div class="flex">
                                        <svg class="w-5 h-5 text-yellow-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-medium text-yellow-900">Urutan Duplikat</h4>
                                            <p class="text-sm text-yellow-700 mt-1">
                                                Jika menggunakan urutan yang sudah ada, sistem akan otomatis menggeser urutan yang lama ke bawah.
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
                                            <h4 class="text-sm font-medium text-green-900">Status Aktif</h4>
                                            <p class="text-sm text-green-700 mt-1">
                                                Hanya struktur dengan status aktif yang akan ditampilkan di website publik.
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
                    input.addEventListener('input', function(e) {
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
