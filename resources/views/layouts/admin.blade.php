<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pastor Charlene Boyd') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="h-full font-sans antialiased bg-white">
    <div class="min-h-full">
        <!-- Sidebar -->
        <x-sidebar />

        <!-- Main content -->
        <div class="lg:pl-64">
            <!-- Top navbar -->
            <div
                class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
                <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                    <div class="flex flex-1">
                        <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                            aria-controls="logo-sidebar" type="button"
                            class="inline-flex items-center p-2 text-gray-400 rounded-lg sm:hidden  hover:text-white focus:outline-none focus:ring-2 focus:ring-orange-500 transition-colors">
                            <span class="sr-only">Close sidebar</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center gap-x-4 lg:gap-x-6">
                        <!-- Profile dropdown -->

                        <div class="relative">
                            <button type="button" class="-m-1.5 flex items-center p-1.5" id="user-menu-button">
                                <span class="sr-only">Open user menu</span>
                                <span class="flex items-center">
                                    <span class="text-sm font-semibold leading-6 text-gray-900"
                                        aria-hidden="true">{{ Auth::user()->name }}</span>
                                </span>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('auth.logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="text-sm font-semibold leading-6 text-gray-900 hover:text-orange-500">Logout</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <main class="py-10">
                <div class="px-4 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
    @livewireScripts
</body>

</html>
