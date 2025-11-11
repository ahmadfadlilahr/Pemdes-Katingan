@extends('layouts.admin.app')

@section('title', 'Kelola Kata Sambutan')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Kelola Kata Sambutan
            </h2>
            <p class="text-sm text-gray-600 mt-1">Kelola kata sambutan yang ditampilkan di halaman utama website</p>
        </div>
        @if($welcomeMessages->count() === 0)
            <a href="{{ route('admin.welcome-messages.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Kata Sambutan
            </a>
        @endif
    </div>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
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

        <!-- Welcome Messages Container -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                @if($welcomeMessages->count() > 0)
                    <div class="grid grid-cols-1 gap-6">
                        @foreach($welcomeMessages as $message)
                            <x-admin.welcome-message-card :message="$message" />
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($welcomeMessages->hasPages())
                        <div class="mt-6">
                            {{ $welcomeMessages->links() }}
                        </div>
                    @endif
                @else
                    <x-admin.welcome-message-empty-state />
                @endif
            </div>
        </div>
    </div>
@endsection
