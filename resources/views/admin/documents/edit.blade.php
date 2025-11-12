@extends('layouts.admin.app')

@section('title', 'Edit Dokumen')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Edit Dokumen
        </h2>
        <a href="{{ route('admin.documents.index') }}"
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
        <form action="{{ route('admin.documents.update', $document) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="xl:col-span-2 space-y-6">
                    <!-- Current File Info -->
                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <h3 class="text-sm font-medium text-blue-900 mb-3">File Saat Ini</h3>
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $document->file_name }}</p>
                                <p class="text-xs text-gray-500">{{ $document->file_size_formatted }} • {{ $document->download_count }} unduhan</p>
                            </div>
                            <a href="{{ route('admin.documents.download', $document) }}"
                               class="text-sm text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Unduh
                            </a>
                        </div>
                    </div>

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Dokumen <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               id="title"
                               value="{{ old('title', $document->title) }}"
                               required
                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('title') @enderror"
                               placeholder="Masukkan judul dokumen">
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
                                  rows="6"
                                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('description') @enderror"
                                  placeholder="Masukkan deskripsi dokumen (opsional)">{{ old('description', $document->description) }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Opsional. Berikan penjelasan singkat tentang dokumen</p>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Upload Settings -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">File & Kategori</h3>

                        <!-- File Upload (Optional) -->
                        <div class="mb-4">
                            <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                                Ganti File (Opsional)
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-blue-400 transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Upload file baru</span>
                                            <input id="file"
                                                   name="file"
                                                   type="file"
                                                   class="sr-only"
                                                   accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip,.rar"
                                                   onchange="displayFileName(this)">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        PDF, DOC, XLS, PPT, TXT, ZIP, RAR
                                    </p>
                                    <p class="text-xs text-yellow-600 mt-1">
                                        Kosongkan jika tidak ingin mengganti file
                                    </p>
                                    <p id="fileName" class="text-sm text-blue-600 font-medium mt-2"></p>
                                </div>
                            </div>
                            @error('file')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                                Kategori
                            </label>
                            <input type="text"
                                   name="category"
                                   id="category"
                                   value="{{ old('category', $document->category) }}"
                                   list="category-suggestions"
                                   autocomplete="off"
                                   class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('category') @enderror text-sm"
                                   placeholder="Pilih atau ketik kategori baru...">

                            <!-- Datalist for category suggestions -->
                            @if($categories->isNotEmpty())
                                <datalist id="category-suggestions">
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}">
                                    @endforeach
                                </datalist>
                            @endif

                            @error('category')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <!-- Help text with category suggestions -->
                            @if($categories->isNotEmpty())
                                <p class="mt-1 text-xs text-gray-500">
                                    Kategori tersedia: <span class="font-medium text-gray-700">{{ $categories->join(', ') }}</span>
                                </p>
                                <p class="mt-1 text-xs text-gray-500">Atau ketik kategori baru untuk menambahkan</p>
                            @else
                                <p class="mt-1 text-xs text-gray-500">Ketik kategori baru (contoh: Peraturan, Laporan, dll.)</p>
                            @endif
                        </div>
                    </div>

                    <!-- Status Settings -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Status Publikasi</h3>

                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox"
                                       name="is_active"
                                       id="is_active"
                                       {{ old('is_active', $document->is_active) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="is_active" class="font-medium text-gray-700">Aktifkan Dokumen</label>
                                <p class="text-gray-500">Dokumen akan ditampilkan di halaman publik</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 mt-6 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.documents.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Update Dokumen
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        function displayFileName(input) {
            const fileName = document.getElementById('fileName');
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const fileSize = (file.size / 1024 / 1024).toFixed(2); // Convert to MB
                fileName.textContent = `File baru terpilih: ${file.name} (${fileSize} MB)`;
            } else {
                fileName.textContent = '';
            }
        }

        // Drag and drop functionality
        const dropZone = document.querySelector('.border-dashed');
        const fileInput = document.getElementById('file');

        if (dropZone && fileInput) {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                dropZone.classList.add('border-blue-500', 'bg-blue-50');
            }

            function unhighlight(e) {
                dropZone.classList.remove('border-blue-500', 'bg-blue-50');
            }

            dropZone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;

                if (files.length > 0) {
                    fileInput.files = files;
                    displayFileName(fileInput);
                }
            }
        }

        // Enhanced category input with visual feedback
        const categoryInput = document.getElementById('category');
        if (categoryInput) {
            // Add visual feedback when user selects from datalist
            categoryInput.addEventListener('input', function() {
                if (this.value.trim()) {
                    this.classList.add('font-medium');
                } else {
                    this.classList.remove('font-medium');
                }
            });

            // Show all suggestions on focus (if browser supports)
            categoryInput.addEventListener('focus', function() {
                this.click();
            });
        }
    </script>
    @endpush
@endsection
