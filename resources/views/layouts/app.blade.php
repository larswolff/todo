<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TODO') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
            <div x-data="{ sidebarOpen: window.innerWidth >= 768 }" class="flex h-screen overflow-hidden">
                <!-- Sidebar -->
                <x-sidebar :active="request()->route()->getName()" />

                <!-- Main Content -->
                <div class="flex flex-col flex-1 w-full overflow-x-hidden overflow-y-auto">
                    <!-- Top Navigation -->
                    <header class="bg-white dark:bg-gray-800 shadow-sm lg:hidden">
                        <div class="px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
                            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                            
                            <div class="flex items-center">
                                <span class="text-blue-600 dark:text-blue-500 font-semibold text-lg">{{ config('app.name', 'TODO') }}</span>
                            </div>

                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            <div class="rounded-full h-8 w-8 bg-blue-600 flex items-center justify-center text-white">
                                                {{ substr(Auth::user()->name, 0, 1) }}
                                            </div>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Manage Account') }}
                                        </div>
                                        
                                        <x-dropdown-link :href="route('profile')">
                                            {{ __('Profile') }}
                                        </x-dropdown-link>

                                        <!-- Authentication -->
                                        <x-dropdown-link href="{{ route('logout') }}">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </div>
                    </header>

                    <!-- Page Content -->
                    <main class="flex-1 py-6 px-4 sm:px-6 lg:px-8">
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>