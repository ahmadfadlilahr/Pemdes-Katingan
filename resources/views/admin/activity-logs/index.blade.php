@extends('layouts.admin.app')

@section('title', 'Log Aktivitas')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Log Aktivitas</h2>
            <p class="mt-1 text-sm text-gray-600">Histori aktivitas admin di sistem</p>
        </div>
        <div class="flex items-center gap-3">
            <!-- Clean Old Logs Button -->
            <form action="{{ route('admin.activity-logs.clean') }}" method="POST"
                  onsubmit="return confirm('Hapus semua log aktivitas yang lebih dari 30 hari?')">
                @csrf
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 active:bg-yellow-800 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Bersihkan Log Lama
                </button>
            </form>
        </div>
    </div>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto">
            <!-- Filters -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6 mb-6">
                <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Search -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">
                                Cari Deskripsi
                            </label>
                            <input type="text"
                                   name="search"
                                   id="search"
                                   value="{{ request('search') }}"
                                   placeholder="Cari..."
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>

                        <!-- User Filter -->
                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">
                                User
                            </label>
                            <select name="user_id"
                                    id="user_id"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                <option value="">Semua User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Action Filter -->
                        <div>
                            <label for="action" class="block text-sm font-medium text-gray-700 mb-1">
                                Aksi
                            </label>
                            <select name="action"
                                    id="action"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                <option value="">Semua Aksi</option>
                                @foreach($actions as $action)
                                    <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                        {{ ucfirst($action) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Model Type Filter -->
                        <div>
                            <label for="model_type" class="block text-sm font-medium text-gray-700 mb-1">
                                Tipe Model
                            </label>
                            <select name="model_type"
                                    id="model_type"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                <option value="">Semua Model</option>
                                @foreach($modelTypes as $model)
                                    <option value="{{ $model['value'] }}" {{ request('model_type') == $model['value'] ? 'selected' : '' }}>
                                        {{ $model['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Start Date -->
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">
                                Tanggal Mulai
                            </label>
                            <input type="date"
                                   name="start_date"
                                   id="start_date"
                                   value="{{ request('start_date') }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>

                        <!-- End Date -->
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">
                                Tanggal Akhir
                            </label>
                            <input type="date"
                                   name="end_date"
                                   id="end_date"
                                   value="{{ request('end_date') }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-2">
                        <button type="submit"
                                class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            Filter
                        </button>
                        <a href="{{ route('admin.activity-logs.index') }}"
                           class="inline-flex items-center justify-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Activity Logs Table -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <!-- Bulk Actions Form -->
                <form id="bulkDeleteForm" method="POST" action="{{ route('admin.activity-logs.bulk-destroy') }}">
                    @csrf
                    @method('DELETE')

                    <!-- Table Header with Bulk Actions -->
                    <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <input type="checkbox"
                                   id="selectAll"
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <label for="selectAll" class="text-sm text-gray-700 font-medium">
                                Pilih Semua
                            </label>
                        </div>
                        <button type="submit"
                                id="bulkDeleteBtn"
                                disabled
                                onclick="return confirm('Hapus log yang dipilih?')"
                                class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus Terpilih
                        </button>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="w-12 px-4 sm:px-6 py-3"></th>
                                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        User
                                    </th>
                                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aktivitas
                                    </th>
                                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                    <th scope="col" class="hidden lg:table-cell px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Model
                                    </th>
                                    <th scope="col" class="hidden md:table-cell px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Waktu
                                    </th>
                                    <th scope="col" class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($logs as $log)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                            <input type="checkbox"
                                                   name="ids[]"
                                                   value="{{ $log->id }}"
                                                   class="log-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                        <span class="text-sm font-medium text-gray-600">
                                                            {{ substr($log->user->name ?? 'S', 0, 1) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $log->user->name ?? 'System' }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $log->ip_address }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 sm:px-6 py-4">
                                            <div class="text-sm text-gray-900 max-w-md">
                                                {{ $log->description }}
                                            </div>
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $log->action_color }}-100 text-{{ $log->action_color }}-800">
                                                {{ $log->action_name }}
                                            </span>
                                        </td>
                                        <td class="hidden lg:table-cell px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $log->model_name }}
                                        </td>
                                        <td class="hidden md:table-cell px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div>{{ $log->created_at->format('d M Y') }}</div>
                                            <div class="text-xs text-gray-400">{{ $log->created_at->format('H:i') }} WIB</div>
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('admin.activity-logs.destroy', $log) }}"
                                                  method="POST"
                                                  class="inline-block"
                                                  onsubmit="return confirm('Hapus log ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-600 hover:text-red-900 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 sm:px-6 py-12 text-center">
                                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                </svg>
                                            </div>
                                            <p class="text-sm text-gray-500">Tidak ada log aktivitas</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </form>

                <!-- Pagination -->
                @if($logs->hasPages())
                    <div class="px-4 sm:px-6 py-4 border-t border-gray-200">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>
    </div>

    @push('scripts')
    <script>
        // Select All Checkbox
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.log-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
            toggleBulkDeleteButton();
        });

        // Individual Checkboxes
        document.querySelectorAll('.log-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', toggleBulkDeleteButton);
        });

        // Toggle Bulk Delete Button
        function toggleBulkDeleteButton() {
            const checkedBoxes = document.querySelectorAll('.log-checkbox:checked');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            bulkDeleteBtn.disabled = checkedBoxes.length === 0;
        }
    </script>
    @endpush
@endsection
