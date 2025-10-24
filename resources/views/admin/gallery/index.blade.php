@extends('layouts.admin.app')

@section('title', 'Kelola Galeri')

@section('header')
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Kelola Galeri
            </h2>
            <p class="text-sm text-gray-600 mt-1">Mengelola foto dan galeri dinas</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.gallery.create') }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg inline-flex items-center transition duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Foto
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

            <!-- Filter & Bulk Actions Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <!-- Filter Section -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Filter & Pencarian</h3>
                        <form method="GET" action="{{ route('admin.gallery.index') }}">
                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                                <!-- Search -->
                                <div>
                                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                                    <input type="text"
                                           name="search"
                                           id="search"
                                           value="{{ request('search') }}"
                                           placeholder="Cari judul, deskripsi..."
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                </div>

                                <!-- Status Filter -->
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                    <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                        <option value="">Semua Status</option>
                                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                </div>

                                <!-- Sort By -->
                                <div>
                                    <label for="sort_by" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                                    <select name="sort_by" id="sort_by" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                        <option value="order" {{ request('sort_by') === 'order' ? 'selected' : '' }}>Urutan</option>
                                        <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Tanggal Upload</option>
                                        <option value="title" {{ request('sort_by') === 'title' ? 'selected' : '' }}>Judul</option>
                                    </select>
                                </div>

                                <!-- Filter Actions -->
                                <div class="flex items-end space-x-2">
                                    <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200 text-sm">
                                        Filter
                                    </button>
                                    <a href="{{ route('admin.gallery.index') }}"
                                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-200 text-sm">
                                        Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Bulk Actions Section -->
                    @if($galleries->count() > 0)
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Massal</h3>
                        <form id="bulkActionForm" method="POST" action="{{ route('admin.gallery.bulk-action') }}">
                            @csrf
                            <div class="flex flex-wrap items-center gap-4">
                                <div class="flex items-center">
                                    <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <label for="selectAll" class="ml-2 text-sm font-medium text-gray-700">Pilih Semua</label>
                                </div>

                                <select name="action" id="bulkAction" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                    <option value="">Pilih Aksi...</option>
                                    <option value="activate">Aktifkan Terpilih</option>
                                    <option value="deactivate">Nonaktifkan Terpilih</option>
                                    <option value="delete" class="text-red-600">Hapus Terpilih</option>
                                </select>

                                <button type="submit"
                                        id="bulkActionBtn"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200 disabled:opacity-50 text-sm"
                                        disabled>
                                    Jalankan Aksi
                                </button>

                                <div class="text-sm text-gray-500">
                                    <span id="selectedCount">0</span> item terpilih
                                </div>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Gallery Grid -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($galleries->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">
                                            <input type="checkbox" id="selectAllTable" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">
                                            Foto
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/8">
                                            Urutan
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/8">
                                            Upload Oleh
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/8">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($galleries as $gallery)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="checkbox"
                                                   name="selected_galleries[]"
                                                   value="{{ $gallery->id }}"
                                                   class="gallery-checkbox rounded border-gray-300 text-blue-600 shadow-sm">
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-start space-x-4">
                                                <img src="{{ Storage::url($gallery->image) }}"
                                                     alt="{{ $gallery->title }}"
                                                     class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                                                <div class="min-w-0 flex-1 max-w-xs">
                                                    <p class="text-sm font-medium text-gray-900 truncate" title="{{ $gallery->title }}">
                                                        {{ Str::limit($gallery->title, 50, '...') }}
                                                    </p>
                                                    @if($gallery->description)
                                                    <p class="text-sm text-gray-500 mt-1 truncate" title="{{ $gallery->description }}">
                                                        {{ Str::limit($gallery->description, 80, '...') }}
                                                    </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-900">{{ $gallery->order }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-900">{{ $gallery->user->name }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($gallery->is_active)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex items-center justify-center space-x-2">
                                                <a href="{{ route('admin.gallery.show', $gallery) }}"
                                                   class="text-blue-600 hover:text-blue-900 transition duration-200"
                                                   title="Lihat">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>

                                                <a href="{{ route('admin.gallery.edit', $gallery) }}"
                                                   class="text-indigo-600 hover:text-indigo-900 transition duration-200"
                                                   title="Edit">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>

                                                <form method="POST" action="{{ route('admin.gallery.destroy', $gallery) }}"
                                                      class="inline"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-red-600 hover:text-red-900 transition duration-200"
                                                            title="Hapus">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>


                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $galleries->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Galeri Kosong</h3>
                            <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan foto ke galeri.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.gallery.create') }}"
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Tambah Foto
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Bulk action functionality
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('selectAll');
            const selectAllTable = document.getElementById('selectAllTable');
            const checkboxes = document.querySelectorAll('.gallery-checkbox');
            const bulkActionSelect = document.getElementById('bulkAction');
            const bulkActionBtn = document.getElementById('bulkActionBtn');
            const bulkActionForm = document.getElementById('bulkActionForm');

            // Select all functionality
            function updateSelectAll() {
                const checkedBoxes = document.querySelectorAll('.gallery-checkbox:checked');
                const allCheckboxes = document.querySelectorAll('.gallery-checkbox');
                const selectedCount = document.getElementById('selectedCount');

                if (selectAll) selectAll.checked = checkedBoxes.length === allCheckboxes.length;
                if (selectAllTable) selectAllTable.checked = checkedBoxes.length === allCheckboxes.length;

                // Update selected count
                if (selectedCount) selectedCount.textContent = checkedBoxes.length;

                // Enable/disable bulk action button
                if (bulkActionBtn) {
                    bulkActionBtn.disabled = checkedBoxes.length === 0 || !bulkActionSelect.value;
                }
            }

            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateSelectAll();
                });
            }

            if (selectAllTable) {
                selectAllTable.addEventListener('change', function() {
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateSelectAll();
                });
            }

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectAll);
            });

            if (bulkActionSelect) {
                bulkActionSelect.addEventListener('change', function() {
                    const checkedBoxes = document.querySelectorAll('.gallery-checkbox:checked');
                    if (bulkActionBtn) {
                        bulkActionBtn.disabled = checkedBoxes.length === 0 || !this.value;
                    }
                });
            }

            // Bulk action form submission
            if (bulkActionForm) {
                bulkActionForm.addEventListener('submit', function(e) {
                    const action = bulkActionSelect.value;
                    const checkedBoxes = document.querySelectorAll('.gallery-checkbox:checked');

                    if (checkedBoxes.length === 0) {
                        e.preventDefault();
                        alert('Pilih minimal satu foto');
                        return;
                    }

                    // Add selected IDs to form
                    const existingInputs = bulkActionForm.querySelectorAll('input[name="selected_galleries[]"]');
                    existingInputs.forEach(input => input.remove());

                    checkedBoxes.forEach(checkbox => {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'selected_galleries[]';
                        hiddenInput.value = checkbox.value;
                        bulkActionForm.appendChild(hiddenInput);
                    });

                    if (action === 'delete') {
                        if (!confirm('Apakah Anda yakin ingin menghapus foto yang dipilih?')) {
                            e.preventDefault();
                        }
                    } else if (action === 'activate') {
                        if (!confirm('Apakah Anda yakin ingin mengaktifkan foto yang dipilih?')) {
                            e.preventDefault();
                        }
                    } else if (action === 'deactivate') {
                        if (!confirm('Apakah Anda yakin ingin menonaktifkan foto yang dipilih?')) {
                            e.preventDefault();
                        }
                    }
                });
            }

            // Initial state
            updateSelectAll();
        });
    </script>
    @endpush
@endsection
