@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Dashboard</h2>
            <p class="mt-1 text-sm text-gray-600">Selamat datang di panel administrasi Dinas PMD</p>
        </div>
        <a href="{{ route('home') }}"
           target="_blank"
           class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            Lihat Website
        </a>
    </div>
@endsection

@section('content')
    @php
        $publishedNews = App\Models\News::where('is_published', true)->count();
        $totalHeroes = App\Models\Hero::count();
        $ongoingAgenda = App\Models\Agenda::where('status', 'ongoing')->count();
        $recentNews = App\Models\News::with('user')->latest()->take(5)->get();
    @endphp

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <x-admin.dashboard.stat-card
            title="Berita Published"
            :value="$publishedNews"
            icon="newspaper"
            color="green"
        />

        <x-admin.dashboard.stat-card
            title="Hero/Slider"
            :value="$totalHeroes"
            icon="photo"
            color="blue"
        />

        <x-admin.dashboard.stat-card
            title="Agenda Berlangsung"
            :value="$ongoingAgenda"
            icon="clock"
            color="orange"
        />
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Recent News -->
        <x-admin.dashboard.recent-news :news="$recentNews" />

        <!-- Quick Actions -->
        <x-admin.dashboard.quick-actions />
    </div>

    <!-- Activity Log Widget - Full Width -->
    <div class="mt-6">
        <x-activity-log-widget :limit="5" />
    </div>
@endsection
