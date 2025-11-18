@props(['limit' => 5])

@php
    $recentLogs = \App\Models\ActivityLog::with('user')->latest()->limit($limit)->get();
@endphp

<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <!-- Header -->
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-purple-100 rounded-lg">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Aktivitas Terbaru</h3>
        </div>
        <a href="{{ route('admin.activity-logs.index') }}"
           class="text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors flex items-center gap-1">
            Lihat Semua
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    <!-- Content -->
    <div class="divide-y divide-gray-100">
        @forelse($recentLogs as $log)
            <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                <div class="flex items-start gap-4">
                    <!-- Icon -->
                    <div class="flex-shrink-0 mt-0.5">
                        <div class="w-10 h-10 rounded-full bg-{{ $log->action_color }}-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-{{ $log->action_color }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $log->action_icon }}"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex-1">
                                <p class="text-sm text-gray-900 font-medium">
                                    {{ $log->user->name ?? 'System' }}
                                    <span class="font-normal text-gray-600">{{ $log->description }}</span>
                                </p>
                                <div class="flex items-center gap-3 mt-1">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-{{ $log->action_color }}-100 text-{{ $log->action_color }}-800">
                                        {{ $log->action_name }}
                                    </span>
                                    @if($log->model_type)
                                        <span class="text-xs text-gray-500">
                                            {{ $log->model_name }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <time class="text-xs text-gray-500 whitespace-nowrap" datetime="{{ $log->created_at->toIso8601String() }}">
                                    {{ $log->created_at->diffForHumans() }}
                                </time>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="px-6 py-12 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="text-sm text-gray-500">Belum ada aktivitas</p>
            </div>
        @endforelse
    </div>

    <!-- Footer - Optional Statistics -->
    @if($recentLogs->isNotEmpty())
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
            <div class="flex items-center justify-between text-xs text-gray-600">
                <span>Total: {{ \App\Models\ActivityLog::count() }} aktivitas</span>
                <span>Hari ini: {{ \App\Models\ActivityLog::whereDate('created_at', today())->count() }} aktivitas</span>
            </div>
        </div>
    @endif
</div>
