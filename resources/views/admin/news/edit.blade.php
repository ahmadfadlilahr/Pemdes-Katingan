@extends('layouts.admin.app')

@section('title', 'Edit Berita')

@section('header')
    <div class="flex flex-col space-y-4 sm:space-y-0 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Edit Berita: {{ Str::limit($news->title, 40) }}
        </h2>
        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
            <a href="{{ route('admin.news.show', $news) }}"
               class="inline-flex items-center justify-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Lihat
            </a>
            <a href="{{ route('admin.news.index') }}"
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
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="xl:col-span-2 space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Berita <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               id="title"
                               value="{{ old('title', $news->title) }}"
                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Masukkan judul berita">
                        @error('title')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Content with TinyMCE -->
                    <x-admin.tinymce-editor
                        id="content"
                        name="content"
                        label="Isi Berita"
                        :value="old('content', $news->content)"
                        :required="true"
                        :height="500"
                        placeholder="Tulis isi berita di sini..."
                    />

                    <!-- Excerpt -->
                    <div>
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                            Ringkasan Berita
                        </label>
                        <textarea name="excerpt"
                                  id="excerpt"
                                  rows="3"
                                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Ringkasan singkat berita (opsional - akan dibuat otomatis jika dikosongkan)">{{ old('excerpt', $news->excerpt) }}</textarea>
                        @error('excerpt')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Maksimal 500 karakter. Jika dikosongkan, akan dibuat otomatis dari isi berita.</p>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Publish Settings -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pengaturan Publikasi</h3>

                        <div class="space-y-4">
                            <!-- Author -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Penulis</label>
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                        <span class="text-xs font-medium text-white">
                                            {{ substr($news->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <span class="text-sm text-gray-900">{{ $news->user->name }}</span>
                                </div>
                            </div>

                            <!-- Publication Info -->
                            <div class="text-sm text-gray-600">
                                <p><strong>Dibuat:</strong> {{ $news->created_at->format('d M Y, H:i') }}</p>
                                @if($news->updated_at->ne($news->created_at))
                                    <p><strong>Diperbarui:</strong> {{ $news->updated_at->format('d M Y, H:i') }}</p>
                                @endif
                                @if($news->published_at)
                                    <p><strong>Dipublikasi:</strong> {{ $news->published_at->format('d M Y, H:i') }}</p>
                                @endif
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="flex items-center">
                                    <input type="hidden" name="is_published" value="0">
                                    <input type="checkbox"
                                           name="is_published"
                                           value="1"
                                           {{ old('is_published', $news->is_published) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">Publikasikan berita</span>
                                </label>
                                <p class="mt-1 text-xs text-gray-500">Centang untuk mempublikasikan berita</p>
                            </div>
                        </div>
                    </div>

                    <!-- Current & New Image -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Gambar Berita</h3>

                        <!-- Current Image -->
                        @if($news->image)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                                <div class="relative">
                                    <img src="{{ Storage::url($news->image) }}"
                                         alt="{{ $news->title }}"
                                         class="w-full h-40 object-cover rounded-md">
                                </div>
                            </div>
                        @endif

                        <!-- Upload New Image -->
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $news->image ? 'Ganti Gambar' : 'Upload Gambar' }}
                            </label>

                            <!-- New Image Preview Area -->
                            <div id="newImagePreviewContainer" class="hidden mb-4">
                                <div class="relative">
                                    <img id="newImagePreview" class="w-full h-40 object-cover rounded-md border" alt="Preview Gambar Baru">
                                    <button type="button" id="removeNewImage" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-sm text-gray-600 mt-2" id="newImageInfo"></p>
                            </div>

                            <!-- Upload Area -->
                            <div id="uploadArea" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors duration-200">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span id="uploadText">{{ $news->image ? 'Ganti gambar' : 'Upload gambar' }}</span>
                                            <input id="image" name="image" type="file" accept="image/*" class="sr-only">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
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
                            Perbarui Berita
                        </button>

                        <a href="{{ route('admin.news.show', $news) }}"
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
            const newPreviewContainer = document.getElementById('newImagePreviewContainer');
            const newImagePreview = document.getElementById('newImagePreview');
            const newImageInfo = document.getElementById('newImageInfo');
            const removeNewImageBtn = document.getElementById('removeNewImage');
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
                        // Show new image preview
                        newImagePreview.src = e.target.result;
                        newImageInfo.textContent = `Gambar baru: ${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;

                        // Hide upload area and show new preview
                        uploadArea.classList.add('hidden');
                        newPreviewContainer.classList.remove('hidden');
                        uploadText.textContent = 'Ganti gambar';
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Handle remove new image
            removeNewImageBtn.addEventListener('click', function() {
                // Clear the input
                imageInput.value = '';

                // Hide new preview and show upload area
                newPreviewContainer.classList.add('hidden');
                uploadArea.classList.remove('hidden');
                uploadText.textContent = @if($news->image) 'Ganti gambar' @else 'Upload gambar' @endif;
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
