<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel') - PMD Kabupaten Katingan</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom Admin Styles -->
    <style>
        /* CSS Reset for admin layout */
        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            overflow-x: hidden;
        }

        /* Desktop sidebar - fixed positioning */
        @media (min-width: 1024px) {
            .admin-sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                overflow-y: auto;
                z-index: 40;
            }

            .admin-main-wrapper {
                margin-left: 16rem; /* w-64 = 16rem */
            }
        }

        /* Mobile sidebar - hide desktop sidebar completely */
        @media (max-width: 1023px) {
            .admin-desktop-sidebar {
                display: none !important;
            }

            .admin-main-wrapper {
                margin-left: 0;
                width: 100%;
            }

            .admin-sidebar {
                position: relative;
                height: 100vh;
                overflow-y: auto;
                width: 100%;
            }
        }

        /* Smooth scrolling for main content */
        .admin-main-content {
            scroll-behavior: smooth;
        }

        /* Custom scrollbar for sidebar */
        .admin-sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .admin-sidebar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .admin-sidebar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 2px;
        }

        .admin-sidebar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Prevent body scroll when mobile sidebar is open */
        .sidebar-open {
            overflow: hidden;
        }

        /* Fix mobile layout issues */
        @media (max-width: 1023px) {
            body {
                margin: 0;
                padding: 0;
            }

            .min-h-screen {
                min-height: 100vh;
                width: 100%;
            }

            /* Ensure no horizontal scroll or white space */
            .admin-main-wrapper {
                width: 100vw;
                max-width: 100%;
                overflow-x: hidden;
            }
        }
    </style>    <!-- Additional Styles -->
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 m-0 p-0" x-data="{ sidebarOpen: false }" :class="{ 'sidebar-open': sidebarOpen }">
    <div class="min-h-screen flex w-full overflow-x-hidden">
        <!-- Mobile sidebar overlay -->
        <div x-show="sidebarOpen"
             class="fixed inset-0 z-50 lg:hidden"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75" @click="sidebarOpen = false"></div>

            <!-- Sidebar panel -->
            <div class="relative flex flex-col w-full max-w-xs bg-white h-full">
                <!-- Close button -->
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button @click="sidebarOpen = false"
                            class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="sr-only">Close sidebar</span>
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Sidebar content -->
                @include('components.admin.sidebar')
            </div>
        </div>

        <!-- Desktop sidebar -->
        <div class="admin-desktop-sidebar hidden lg:flex lg:flex-shrink-0">
            @include('components.admin.sidebar')
        </div>

        <!-- Main content -->
        <div class="admin-main-wrapper flex-1 flex flex-col min-w-0 lg:ml-0">
            <!-- Top Navigation -->
            @include('components.admin.navbar', ['title' => $title ?? 'Dashboard'])

            <!-- Page Content -->
            <main class="admin-main-content flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                <div class="container mx-auto px-4 sm:px-6 py-8">
                    <!-- Page Header -->
                    @hasSection('header')
                        <div class="mb-8">
                            @yield('header')
                        </div>
                    @endif

                    <!-- Flash Messages -->
                    @if(session('success'))
                        @include('components.admin.alert', ['type' => 'success', 'message' => session('success')])
                    @endif

                    @if(session('error'))
                        @include('components.admin.alert', ['type' => 'error', 'message' => session('error')])
                    @endif

                    @if($errors->any())
                        @include('components.admin.alert', ['type' => 'error', 'message' => 'Terdapat kesalahan pada form yang diisi.'])
                    @endif

                    <!-- Main Content -->
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>
