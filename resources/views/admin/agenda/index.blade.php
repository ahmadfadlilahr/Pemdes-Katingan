@extends('layouts.admin.app')

@section('title', 'Kelola Agenda')

@section('header')
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Kelola Agenda
            </h2>
            <p class="text-sm text-gray-600 mt-1">Mengelola agenda kegiatan dinas</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.agenda.create') }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg inline-flex items-center transition duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Agenda
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-6">
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

            <!-- Combined Filter & Bulk Actions Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <!-- Filter Section -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Filter & Pencarian</h3>
                        <form method="GET" action="{{ route('admin.agenda.index') }}">
                            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
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
                                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                                        <option value="ongoing" {{ request('status') === 'ongoing' ? 'selected' : '' }}>Berlangsung</option>
                                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                </div>

                                <!-- Sort By -->
                                <div>
                                    <label for="sort_by" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                                    <select name="sort_by" id="sort_by" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                        <option value="default" {{ request('sort_by') === 'default' ? 'selected' : '' }}>Default</option>
                                        <option value="start_date" {{ request('sort_by') === 'start_date' ? 'selected' : '' }}>Tanggal Mulai</option>
                                        <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Tanggal Dibuat</option>
                                        <option value="title" {{ request('sort_by') === 'title' ? 'selected' : '' }}>Judul</option>
                                    </select>
                                </div>

                                <!-- Sort Order -->
                                <div>
                                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                                    <select name="sort_order" id="sort_order" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                        <option value="desc" {{ request('sort_order') === 'desc' ? 'selected' : '' }}>Terbaru</option>
                                        <option value="asc" {{ request('sort_order') === 'asc' ? 'selected' : '' }}>Terlama</option>
                                    </select>
                                </div>

                                <!-- Filter Actions -->
                                <div class="flex items-end space-x-2">
                                    <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200 text-sm">
                                        Filter
                                    </button>
                                    <a href="{{ route('admin.agenda.index') }}"
                                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-200 text-sm">
                                        Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Bulk Actions Section -->
                    @if($agendas->count() > 0)
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Massal</h3>
                        <form id="bulkActionForm" method="POST" action="{{ route('admin.agenda.bulk-action') }}">
                            @csrf
                            <div class="flex flex-wrap items-center gap-4">
                                <div class="flex items-center">
                                    <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <label for="selectAll" class="ml-2 text-sm font-medium text-gray-700">Pilih Semua</label>
                                </div>

                                <select name="action" id="bulkAction" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                    <option value="">Pilih Aksi...</option>
                                    <option value="activate">Aktifkan</option>
                                    <option value="deactivate">Nonaktifkan</option>
                                    <option value="draft">Set Draft</option>
                                    <option value="scheduled">Set Terjadwal</option>
                                    <option value="cancelled">Set Dibatalkan</option>
                                    <option value="delete" class="text-red-600">Hapus</option>
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

            <!-- Agenda List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($agendas->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">
                                            <input type="checkbox" id="selectAllTable" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">
                                            Agenda
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">
                                            Tanggal & Waktu
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/8">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/8">
                                            Dibuat Oleh
                                        </th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($agendas as $agenda)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="checkbox"
                                                   name="agenda_ids[]"
                                                   value="{{ $agenda->id }}"
                                                   class="agenda-checkbox rounded border-gray-300 text-blue-600 shadow-sm"
                                                   form="bulkActionForm">
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-start space-x-4">
                                                @if($agenda->image)
                                                    <img src="{{ $agenda->image_url }}"
                                                         alt="{{ $agenda->title }}"
                                                         class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                                                @else
                                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                                <div class="min-w-0 flex-1 max-w-xs">
                                                    <p class="text-sm font-medium text-gray-900 truncate" title="{{ $agenda->title }}">
                                                        {{ Str::limit($agenda->title, 50, '...') }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 mt-1 truncate">
                                                        {{ Str::limit($agenda->description, 80, '...') }}
                                                    </p>
                                                    @if($agenda->location)
                                                        <p class="text-xs text-gray-400 mt-1 flex items-center truncate">
                                                            <svg class="w-3 h-3 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            </svg>
                                                            <span class="truncate">{{ Str::limit($agenda->location, 30, '...') }}</span>
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $agenda->date_range }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $agenda->duration }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col space-y-1">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($agenda->status === 'draft') bg-gray-100 text-gray-800
                                                    @elseif($agenda->status === 'scheduled')
                                                    @elseif($agenda->status === 'ongoing')
                                                    @elseif($agenda->status === 'completed')
                                                    @elseif($agenda->status === 'cancelled')
                                                    @endif">
                                                    {{ $agenda->status_label }}
                                                </span>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ $agenda->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                    {{ $agenda->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $agenda->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $agenda->created_at->format('d M Y') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex items-center justify-center space-x-2">
                                                <a href="{{ route('admin.agenda.show', $agenda) }}"
                                                   class="text-blue-600 hover:text-blue-900 transition duration-200">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>

                                                <a href="{{ route('admin.agenda.edit', $agenda) }}"
                                                   class="text-indigo-600 hover:text-indigo-900 transition duration-200">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>

                                                <form method="POST" action="{{ route('admin.agenda.toggle-status', $agenda) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                            class="text-{{ $agenda->is_active ? 'yellow' : 'green' }}-600 hover:text-{{ $agenda->is_active ? 'yellow' : 'green' }}-900 transition duration-200"
                                                            title="{{ $agenda->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                        @if($agenda->is_active)
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                            </svg>
                                                        @else
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        @endif
                                                    </button>
                                                </form>

                                                <form method="POST" action="{{ route('admin.agenda.destroy', $agenda) }}"
                                                      class="inline"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus agenda ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-red-600 hover:text-red-900 transition duration-200">
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
                            {{ $agendas->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada agenda</h3>
                            <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat agenda baru.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.agenda.create') }}"
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Tambah Agenda
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
            const checkboxes = document.querySelectorAll('.agenda-checkbox');
            const bulkActionSelect = document.getElementById('bulkAction');
            const bulkActionBtn = document.getElementById('bulkActionBtn');
            const bulkActionForm = document.getElementById('bulkActionForm');

            // Select all functionality
            function updateSelectAll() {
                const checkedBoxes = document.querySelectorAll('.agenda-checkbox:checked');
                const allCheckboxes = document.querySelectorAll('.agenda-checkbox');
                const selectedCount = document.getElementById('selectedCount');

                if (selectAll) selectAll.checked = checkedBoxes.length === allCheckboxes.length;
                if (selectAllTable) selectAllTable.checked = checkedBoxes.length === allCheckboxes.length;

                // Update selected count
                if (selectedCount) selectedCount.textContent = checkedBoxes.length;

                // Enable/disable bulk action button
                bulkActionBtn.disabled = checkedBoxes.length === 0 || !bulkActionSelect.value;
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

            bulkActionSelect.addEventListener('change', function() {
                const checkedBoxes = document.querySelectorAll('.agenda-checkbox:checked');
                bulkActionBtn.disabled = checkedBoxes.length === 0 || !this.value;
            });

            // Bulk action form submission
            if (bulkActionForm) {
                bulkActionForm.addEventListener('submit', function(e) {
                    const action = bulkActionSelect.value;
                    const checkedBoxes = document.querySelectorAll('.agenda-checkbox:checked');

                    if (checkedBoxes.length === 0) {
                        e.preventDefault();
                        alert('Pilih minimal satu agenda');
                        return;
                    }

                    if (action === 'delete') {
                        if (!confirm('Apakah Anda yakin ingin menghapus agenda yang dipilih?')) {
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
