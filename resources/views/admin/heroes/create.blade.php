@extends('layouts.admin.app')

@section('title', 'Tambah Hero/Slider')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Tambah Hero/Slider Baru
        </h2>
        <a href="{{ route('admin.heroes.index') }}"
           class="inline-flex items-center justify-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <form action="{{ route('admin.heroes.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="xl:col-span-2 space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Hero <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               id="title"
                               value="{{ old('title') }}"
                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-300 @enderror"
                               placeholder="Masukkan judul hero">
                        @error('title')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea name="description"
                                  id="description"
                                  rows="4"
                                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-300 @enderror"
                                  placeholder="Deskripsi hero (opsional)">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Maksimal 1000 karakter. Opsional.</p>
                    </div>

                    <!-- Buttons Section -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pengaturan Tombol (Opsional)</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Button 1 -->
                            <div class="space-y-4">
                                <h4 class="font-medium text-gray-700">Tombol 1</h4>

                                <div>
                                    <label for="button1_text" class="block text-sm font-medium text-gray-700 mb-2">
                                        Teks Tombol 1
                                    </label>
                                    <input type="text"
                                           name="button1_text"
                                           id="button1_text"
                                           value="{{ old('button1_text') }}"
                                           class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('button1_text') border-red-300 @enderror"
                                           placeholder="Contoh: Selengkapnya">
                                    @error('button1_text')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="button1_url" class="block text-sm font-medium text-gray-700 mb-2">
                                        URL Tombol 1
                                    </label>
                                    <input type="url"
                                           name="button1_url"
                                           id="button1_url"
                                           value="{{ old('button1_url') }}"
                                           class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('button1_url') border-red-300 @enderror"
                                           placeholder="https://example.com">
                                    @error('button1_url')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="button1_style" class="block text-sm font-medium text-gray-700 mb-2">
                                        Style Tombol 1
                                    </label>
                                    <select name="button1_style"
                                            id="button1_style"
                                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="primary" {{ old('button1_style') === 'primary' ? 'selected' : '' }}>Primary (Biru)</option>
                                        <option value="secondary" {{ old('button1_style') === 'secondary' ? 'selected' : '' }}>Secondary (Putih)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Button 2 -->
                            <div class="space-y-4">
                                <h4 class="font-medium text-gray-700">Tombol 2</h4>

                                <div>
                                    <label for="button2_text" class="block text-sm font-medium text-gray-700 mb-2">
                                        Teks Tombol 2
                                    </label>
                                    <input type="text"
                                           name="button2_text"
                                           id="button2_text"
                                           value="{{ old('button2_text') }}"
                                           class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('button2_text') border-red-300 @enderror"
                                           placeholder="Contoh: Kontak Kami">
                                    @error('button2_text')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="button2_url" class="block text-sm font-medium text-gray-700 mb-2">
                                        URL Tombol 2
                                    </label>
                                    <input type="url"
                                           name="button2_url"
                                           id="button2_url"
                                           value="{{ old('button2_url') }}"
                                           class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('button2_url') border-red-300 @enderror"
                                           placeholder="https://example.com">
                                    @error('button2_url')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="button2_style" class="block text-sm font-medium text-gray-700 mb-2">
                                        Style Tombol 2
                                    </label>
                                    <select name="button2_style"
                                            id="button2_style"
                                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="secondary" {{ old('button2_style') === 'secondary' ? 'selected' : '' }}>Secondary (Putih)</option>
                                        <option value="primary" {{ old('button2_style') === 'primary' ? 'selected' : '' }}>Primary (Biru)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Status Settings -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pengaturan Status</h3>

                        <div class="space-y-4">
                            <!-- Author (Read-only) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pembuat</label>
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                        <span class="text-xs font-medium text-white">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <span class="text-sm text-gray-900">{{ auth()->user()->name }}</span>
                                </div>
                            </div>

                            <!-- Active Status -->
                            <div>
                                <label class="flex items-center">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox"
                                           name="is_active"
                                           value="1"
                                           {{ old('is_active', 1) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">Aktifkan hero</span>
                                </label>
                                <p class="mt-1 text-xs text-gray-500">Centang untuk mengaktifkan hero di website</p>
                            </div>

                            <!-- Show Title -->
                            <div>
                                <label class="flex items-center">
                                    <input type="hidden" name="show_title" value="0">
                                    <input type="checkbox"
                                           name="show_title"
                                           value="1"
                                           {{ old('show_title', 1) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">Tampilkan judul</span>
                                </label>
                                <p class="mt-1 text-xs text-gray-500">Centang untuk menampilkan judul di website</p>
                            </div>

                            <!-- Order Position -->
                            <div>
                                <label for="order_position" class="block text-sm font-medium text-gray-700 mb-2">
                                    Posisi Urutan
                                </label>
                                <input type="number"
                                       name="order_position"
                                       id="order_position"
                                       value="{{ old('order_position') }}"
                                       min="0"
                                       class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="0">
                                <p class="mt-1 text-xs text-gray-500">Semakin kecil angka, semakin di depan urutan. Kosongkan untuk otomatis.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Gambar Hero <span class="text-red-500">*</span></h3>

                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                                Upload Gambar
                            </label>
                            <!-- Image Preview Area -->
                            <div id="imagePreviewContainer" class="hidden mb-4">
                                <div class="relative">
                                    <img id="imagePreview" class="w-full h-40 object-cover rounded-md border" alt="Preview">
                                    <button type="button" id="removeImage" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-sm text-gray-600 mt-2" id="imageInfo"></p>
                            </div>

                            <!-- Upload Area -->
                            <div id="uploadArea" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors duration-200">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span id="uploadText">Upload gambar</span>
                                            <input id="image" name="image" type="file" accept="image/*" class="sr-only" required>
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF, WebP hingga 2MB</p>
                                    <p class="text-xs text-gray-400">Recommended: 1920x1080px untuk hasil terbaik</p>
                                </div>
                            </div>
                            @error('image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Hero
                        </button>

                        <a href="{{ route('admin.heroes.index') }}"
                           class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image');
            const uploadArea = document.getElementById('uploadArea');
            const previewContainer = document.getElementById('imagePreviewContainer');
            const imagePreview = document.getElementById('imagePreview');
            const imageInfo = document.getElementById('imageInfo');
            const removeImageBtn = document.getElementById('removeImage');
            const uploadText = document.getElementById('uploadText');

            // Handle file input change
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Validate file type
                    if (!file.type.match('image.*')) {
                        alert('Please select a valid image file.');
                        return;
                    }

                    // Validate file size (2MB = 2097152 bytes)
                    if (file.size > 2097152) {
                        alert('File size must be less than 2MB.');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Show preview
                        imagePreview.src = e.target.result;
                        imageInfo.textContent = `${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;

                        // Hide upload area and show preview
                        uploadArea.classList.add('hidden');
                        previewContainer.classList.remove('hidden');
                        uploadText.textContent = 'Ganti gambar';
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Handle remove image
            removeImageBtn.addEventListener('click', function() {
                // Clear the input
                imageInput.value = '';

                // Hide preview and show upload area
                previewContainer.classList.add('hidden');
                uploadArea.classList.remove('hidden');
                uploadText.textContent = 'Upload gambar';
            });

            // Handle drag and drop
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                uploadArea.classList.add('border-blue-400', 'bg-blue-50');
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('border-blue-400', 'bg-blue-50');
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('border-blue-400', 'bg-blue-50');

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    imageInput.files = files;
                    // Trigger change event
                    const event = new Event('change', { bubbles: true });
                    imageInput.dispatchEvent(event);
                }
            });
        });
    </script>
    @endpush
@endsection
