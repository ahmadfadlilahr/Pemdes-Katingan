@extends('layouts.admin.app')

@section('title', 'Tambah Agenda Baru')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Tambah Agenda Baru
        </h2>
        <a href="{{ route('admin.agenda.index') }}"
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
        <form action="{{ route('admin.agenda.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf

            <!-- Alert Messages -->
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

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium mb-2">Terjadi kesalahan:</p>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="xl:col-span-2 space-y-6">

                        <!-- Informasi Dasar -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Informasi Dasar</h3>

                            <!-- Judul -->
                            <div class="mb-4">
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                    Judul Agenda <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       name="title"
                                       id="title"
                                       value="{{ old('title') }}"
                                       required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('title') @enderror"
                                       placeholder="Masukkan judul agenda">
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div class="mb-4">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Deskripsi <span class="text-red-500">*</span>
                                </label>
                                <textarea name="description"
                                          id="description"
                                          rows="4"
                                          required
                                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('description') @enderror"
                                          placeholder="Masukkan deskripsi agenda">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Lokasi -->
                            <div class="mb-4">
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                                    Lokasi
                                </label>
                                <input type="text"
                                       name="location"
                                       id="location"
                                       value="{{ old('location') }}"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('location') @enderror"
                                       placeholder="Masukkan lokasi kegiatan">
                                @error('location')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Waktu & Tanggal -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Waktu & Tanggal</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Tanggal Mulai -->
                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                        Tanggal Mulai <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date"
                                           name="start_date"
                                           id="start_date"
                                           value="{{ old('start_date') }}"
                                           min="{{ date('Y-m-d') }}"
                                           required
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('start_date') @enderror">
                                    @error('start_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tanggal Selesai -->
                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                        Tanggal Selesai <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date"
                                           name="end_date"
                                           id="end_date"
                                           value="{{ old('end_date') }}"
                                           min="{{ date('Y-m-d') }}"
                                           required
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('end_date') @enderror">
                                    @error('end_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Jam Mulai -->
                                <div>
                                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">
                                        Jam Mulai
                                    </label>
                                    <input type="time"
                                           name="start_time"
                                           id="start_time"
                                           value="{{ old('start_time') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('start_time') @enderror">
                                    @error('start_time')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Jam Selesai -->
                                <div>
                                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">
                                        Jam Selesai
                                    </label>
                                    <input type="time"
                                           name="end_time"
                                           id="end_time"
                                           value="{{ old('end_time') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('end_time') @enderror">
                                    @error('end_time')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Pengaturan</h3>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select name="status"
                                        id="status"
                                        required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('status') @enderror">
                                    <option value="">Pilih Status</option>
                                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="scheduled" {{ old('status', 'scheduled') === 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                                    <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Publish Settings -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pengaturan Publikasi</h3>

                        <div class="space-y-4">
                            <!-- Author (Read-only) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Dibuat oleh</label>
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                        <span class="text-xs font-medium text-white">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <span class="text-sm text-gray-900">{{ auth()->user()->name }}</span>
                                </div>
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="flex items-center">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox"
                                           name="is_active"
                                           value="1"
                                           {{ old('is_active', true) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">Tampilkan di halaman publik</span>
                                </label>
                                <p class="mt-1 text-xs text-gray-500">Centang untuk menampilkan agenda di website publik</p>
                                @error('is_active')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Media Upload -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Media</h3>

                        <div class="space-y-4">
                            <!-- Image Upload -->
                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                                    Gambar Agenda
                                </label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors duration-200">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>Upload gambar</span>
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

                            <!-- Document Upload -->
                            <div>
                                <label for="document" class="block text-sm font-medium text-gray-700 mb-2">
                                    Dokumen Pendukung
                                </label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors duration-200">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5l7-7 7 7M9 20h6" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="document" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>Upload dokumen</span>
                                                <input id="document" name="document" type="file" accept=".pdf,.doc,.docx,.xlsx,.xls" class="sr-only">
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PDF, DOC, DOCX, XLS, XLSX maksimal 5MB</p>
                                    </div>
                                </div>
                                @error('document')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Agenda
                        </button>

                        <a href="{{ route('admin.agenda.index') }}"
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
            // Auto-set end date when start date changes
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            startDateInput.addEventListener('change', function() {
                if (this.value && (!endDateInput.value || endDateInput.value < this.value)) {
                    endDateInput.value = this.value;
                }
                endDateInput.min = this.value;
            });

            // Validate end time is after start time
            const startTimeInput = document.getElementById('start_time');
            const endTimeInput = document.getElementById('end_time');

            function validateTime() {
                if (startTimeInput.value && endTimeInput.value) {
                    if (startDateInput.value === endDateInput.value && endTimeInput.value <= startTimeInput.value) {
                        endTimeInput.setCustomValidity('Jam selesai harus setelah jam mulai');
                    } else {
                        endTimeInput.setCustomValidity('');
                    }
                }
            }

            startTimeInput.addEventListener('change', validateTime);
            endTimeInput.addEventListener('change', validateTime);

            // File upload preview
            const imageInput = document.getElementById('image');
            const documentInput = document.getElementById('document');

            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const fileSize = file.size / 1024 / 1024; // MB
                    if (fileSize > 2) {
                        alert('Ukuran gambar terlalu besar. Maksimal 2MB.');
                        this.value = '';
                        return;
                    }

                    // Show file name with preview
                    const label = this.parentElement;
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        label.innerHTML = `
                            <div class="flex items-center space-x-2">
                                <img src="${e.target.result}" class="w-8 h-8 object-cover rounded" alt="Preview">
                                <span class="text-green-600 text-sm">${file.name}</span>
                            </div>
                            <input id="image" name="image" type="file" accept="image/*" class="sr-only">
                        `;

                        // Re-attach event listener to new input
                        const newInput = label.querySelector('input[type="file"]');
                        newInput.files = imageInput.files; // Keep the selected file
                        newInput.addEventListener('change', arguments.callee.bind(imageInput));
                    };
                    reader.readAsDataURL(file);
                }
            });

            documentInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const fileSize = file.size / 1024 / 1024; // MB
                    if (fileSize > 5) {
                        alert('Ukuran dokumen terlalu besar. Maksimal 5MB.');
                        this.value = '';
                        return;
                    }

                    // Show file name with icon
                    const label = this.parentElement;
                    label.innerHTML = `
                        <div class="flex items-center space-x-2">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-green-600 text-sm">${file.name}</span>
                        </div>
                        <input id="document" name="document" type="file" accept=".pdf,.doc,.docx,.xlsx,.xls" class="sr-only">
                    `;

                    // Re-attach event listener to new input
                    const newInput = label.querySelector('input[type="file"]');
                    newInput.files = documentInput.files; // Keep the selected file
                    newInput.addEventListener('change', arguments.callee.bind(documentInput));
                }
            });

            // Form submit debugging
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                console.log('Form is being submitted');
                console.log('Form action:', this.action);
                console.log('Form method:', this.method);
                console.log('Form enctype:', this.enctype);

                // Check file inputs specifically
                const imageInput = document.getElementById('image');
                const documentInput = document.getElementById('document');

                console.log('Image input:', imageInput);
                console.log('Image files:', imageInput.files);
                console.log('Document input:', documentInput);
                console.log('Document files:', documentInput.files);

                // Log all form data
                const formData = new FormData(this);
                for (let [key, value] of formData.entries()) {
                    if (value instanceof File) {
                        console.log(key, 'FILE:', value.name, value.size, 'bytes');
                    } else {
                        console.log(key, value);
                    }
                }
            });
        });
    </script>
    @endpush
@endsection
