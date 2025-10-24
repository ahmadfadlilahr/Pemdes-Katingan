@extends('layouts.admin.app')

@section('title', 'Edit Agenda')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Edit Agenda: {{ $agenda->title }}
        </h2>
        <div class="flex space-x-2">
            <a href="{{ route('admin.agenda.show', $agenda) }}"
               class="inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Lihat
            </a>
            <a href="{{ route('admin.agenda.index') }}"
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
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium">Terdapat beberapa kesalahan:</h3>
                    <ul class="mt-2 text-sm list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <form action="{{ route('admin.agenda.update', $agenda) }}" method="POST" enctype="multipart/form-data" class="p-6">
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                @csrf
                @method('PATCH')

                <!-- Main Content (2/3 width) -->
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
                                       value="{{ old('title', $agenda->title) }}"
                                       required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('title') border-red-300 @enderror"
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
                                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-300 @enderror"
                                          placeholder="Masukkan deskripsi agenda">{{ old('description', $agenda->description) }}</textarea>
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
                                       value="{{ old('location', $agenda->location) }}"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('location') border-red-300 @enderror"
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
                                           value="{{ old('start_date', $agenda->start_date->format('Y-m-d')) }}"
                                           required
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('start_date') border-red-300 @enderror">
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
                                           value="{{ old('end_date', $agenda->end_date->format('Y-m-d')) }}"
                                           required
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('end_date') border-red-300 @enderror">
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
                                           value="{{ old('start_time', $agenda->start_time ? $agenda->start_time->format('H:i') : '') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('start_time') border-red-300 @enderror">
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
                                           value="{{ old('end_time', $agenda->end_time ? $agenda->end_time->format('H:i') : '') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('end_time') border-red-300 @enderror">
                                    @error('end_time')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>



                        <!-- Pengaturan -->
                        <div class="pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Pengaturan</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Status -->
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                        Status <span class="text-red-500">*</span>
                                    </label>
                                    <select name="status"
                                            id="status"
                                            required
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('status') border-red-300 @enderror">
                                        <option value="">Pilih Status</option>
                                        <option value="draft" {{ old('status', $agenda->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="scheduled" {{ old('status', $agenda->status) === 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                                        <option value="ongoing" {{ old('status', $agenda->status) === 'ongoing' ? 'selected' : '' }}>Berlangsung</option>
                                        <option value="completed" {{ old('status', $agenda->status) === 'completed' ? 'selected' : '' }}>Selesai</option>
                                        <option value="cancelled" {{ old('status', $agenda->status) === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <div class="text-sm text-gray-500">
                            <span class="text-red-500">*</span> Field wajib diisi
                        </div>
                        <div class="flex space-x-4">
                            <a href="{{ route('admin.agenda.show', $agenda) }}"
                               class="inline-flex items-center justify-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Update Agenda
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar (1/3 width) -->
                <div class="space-y-6">
                    <!-- Publication Settings -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pengaturan Publikasi</h3>

                        <!-- Author -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pembuat</label>
                            <p class="text-sm text-gray-600">{{ auth()->user()->name }}</p>
                        </div>

                        <!-- Status Active -->
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1"
                                       @if(old('is_active', $agenda->is_active)) checked @endif
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Aktifkan agenda</span>
                            </label>
                        </div>
                    </div>

                    <!-- Media Upload -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Media</h3>

                        <!-- Image Upload -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Agenda</label>
                            @if($agenda->image)
                                <div class="mb-2">
                                    <img src="{{ $agenda->image_url }}"
                                         alt="Current image"
                                         class="w-32 h-32 object-cover rounded border border-gray-200">
                                    <label class="block mt-2">
                                        <input type="checkbox" name="remove_image" value="1" class="mr-2">
                                        <span class="text-sm text-red-600">Hapus gambar</span>
                                    </label>
                                </div>
                            @endif
                            <label class="block border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 cursor-pointer">
                                <svg class="w-8 h-8 mx-auto mb-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <span class="text-sm text-gray-600">Upload gambar baru</span>
                                <input id="image" type="file" name="image" accept="image/*" class="hidden">
                            </label>
                        </div>

                        <!-- Document Upload -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dokumen Pendukung</label>
                            @if($agenda->document)
                                <div class="mb-2 p-3 bg-white border border-gray-200 rounded-lg">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <a href="{{ $agenda->document_url }}"
                                           target="_blank"
                                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            Lihat dokumen saat ini
                                        </a>
                                    </div>
                                    <label class="block mt-2">
                                        <input type="checkbox" name="remove_document" value="1" class="mr-2">
                                        <span class="text-sm text-red-600">Hapus dokumen</span>
                                    </label>
                                </div>
                            @endif
                            <label class="block border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 cursor-pointer">
                                <svg class="w-8 h-8 mx-auto mb-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="text-sm text-gray-600">Upload dokumen baru</span>
                                <input id="document" type="file" name="document" accept=".pdf,.doc,.docx" class="hidden">
                            </label>
                        </div>
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
                if (this.value && endDateInput.value < this.value) {
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
                            <input id="image" type="file" name="image" accept="image/*" class="hidden">
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
                        <input id="document" type="file" name="document" accept=".pdf,.doc,.docx" class="hidden">
                    `;

                    // Re-attach event listener to new input
                    const newInput = label.querySelector('input[type="file"]');
                    newInput.files = documentInput.files; // Keep the selected file
                    newInput.addEventListener('change', arguments.callee.bind(documentInput));
                }
            });

            // Remove file checkbox handling
            const removeImageCheckbox = document.querySelector('input[name="remove_image"]');
            const removeDocumentCheckbox = document.querySelector('input[name="remove_document"]');

            if (removeImageCheckbox) {
                removeImageCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        imageInput.value = '';
                        imageInput.required = false;
                    }
                });
            }

            if (removeDocumentCheckbox) {
                removeDocumentCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        documentInput.value = '';
                    }
                });
            }
        });
    </script>
    @endpush
@endsection
